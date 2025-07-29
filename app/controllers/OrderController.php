<?php


    namespace App\Controllers;

    use App\Core\Cart;
    use App\Core\Notify;
    use App\Models\Order;
    use App\Core\Controller;
    use App\Enums\OrderStatus;
    use App\Core\Mail;
    use PDOException;

    class OrderController extends Controller
    {
        private $repository;
        public function __construct()
        {
            $this->repository = new Order();
        }
        public function index()
        {
            $orders = $this->repository->all();
            $this->view("orders/index", ['orders' => $orders]);
        }
        public function create()
        {
            if( !Cart::freight() ){
                Notify::add([
                    'request' => false,
                    'httpCode' => 200,
                    'message' => 'Endereço de entrega não foi definido.',
                    'metadata' => '',
                ]);

                $this->redirect("/checkout");
            }

            $insights = Cart::insights();
            $cart = cart::all();
            
            $order = $_POST;
            $order['coupon_id'] = Cart::discount()['id_coupon'] ?? 0;
            $order['order_code'] = date('YmdHis');
            $order['order_total_freight'] = $insights['freight'];
            $order['order_total_discount'] = $insights['discount'];
            $order['order_value_total'] = $insights['total'];
            $order['order_status'] = 'PENDENTE';

            $items = "";
            
            $id_order = $this->repository->create($order);
            if( $id_order ){
                foreach($cart['items'] as $item){
                    $this->repository->createItem([
                        'order_id' => $id_order,
                        'sku_id' => $item['id_sku'],
                        'order_item_quantity' => $item['item_quantity']
                    ]);

                    $items .= "<tr><td>".$item['item_name']."</td><td>".$item['item_quantity']."</td><td>R$ ".number_format($item['item_value'],2)."</td></tr>";
                }
            }

            $keyWords['client_name'] = $order['order_client_name'];
            $keyWords['data_order'] = date('d/m/Y H:i');
            $keyWords['order_code'] = $order['order_code'];
            $keyWords['order_status'] = "PENDENTE";
            $keyWords['order_items'] = $items;
            $keyWords['order_shipping'] = "Endereço: " . $cart['freight']['address'] . ", CEP: " . $cart['freight']['zipcode'] . "<br>modalidade: " . $cart['freight']['method'] . " (R$ ".number_format($cart['freight']['value'], 2).")";
            $keyWords['order_total'] = "R$ " . number_format($cart['totals']['total'], 2);

            $mail = new Mail();
            $mail
                ->template('notification-new-order', $keyWords)
                ->sendTo($order['order_client_name'], $order['order_client_email'], 'Pedido Criado - MTK Tiny ERP');

            Cart::storage($order['order_code']);
            Cart::destroy();
            
            $this->redirect(("/orders/invoice/".$order['order_code']));
        }
        public function invoice($code)
        {
            $invoice = $this->repository->getByCode($code);
            $this->view("orders/invoice", ['invoice' => $invoice]);
        }
        // webhook
        public function tracking()
        {

            $input = file_get_contents("php://input");
            $data  = json_decode($input, true);

            // validando entrada
            $errors  = [];
            $fields = ['code', 'status'];
            foreach($fields as $field){
                if(!isset($data[$field]) or empty($data[$field])){
                    $errors[] = "O campo " . $field . " deve ser declarado e não pode ser vazio.";
                }
            }

            // validando status
            $statuses = OrderStatus::cases();
            $stat = array_map(fn($status) => strtoupper($status->name),OrderStatus::cases());

            if( !in_array(strtoupper($data['status']), $stat) ){
                $errors[] = "O status " . $data['status'] . " não é um valor valido, permitidos: " . implode(", ", $stat);
            }

            if( count($errors) > 0 ){
                return json_encode(['error' => true, 'message' => implode(", ", $errors)]);
            }

            // validação de pedido
            $order = $this->repository->getByCode($data['code']);
            if(!$order){
                http_response_code(404);
                return json_encode(['error' => true, 'message' => 'O pedido ' . $data['code'] . ' não foi encontrado.']);
            }

            try {

                // remover o pedido se cancelado
                if( $data['status'] == "CANCELADO" ){
                    http_response_code(200);
                    return json_encode([
                        'error' => false,
                        'message' => 'Pedido Cancelado com sucesso, registro removido dos repositorios.'
                    ]);
                }

                 // alteração de status
                if( $this->repository->changeStatus($order[0]['id_order'], strtoupper($data['status'])) ){
                    http_response_code(200);
                    return json_encode([
                        'error' => false,
                        'message' => 'Status de pedido alterado de ' . $order[0]['order_status'] . ' para ' . $data['status']
                    ]);
                }else{

                    http_response_code(400);
                    return json_encode([
                        'error' => true,
                        'message' => 'Falha ao atualizar o status do pedido.'
                    ]);
                }
            } catch(PDOException $e){

                http_response_code(500);
                return json_encode([
                    'error' => true,
                    'message' => 'Erro interno de servidor',
                    'exception' => $e
                ]);
            }
        }
    }