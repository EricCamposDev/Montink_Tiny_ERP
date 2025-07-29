    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const formatter = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
            minimumFractionDigits: 2
        });

        function maskMoney(e) {
            const input = e.target;
            let valor = input.value.replace(/\D/g, '');

            const maxDigits = parseInt(input.dataset.maxDigits);
            if (valor.length > maxDigits) {
                valor = valor.substring(0, maxDigits);
            }

            input.value = formatter.format(parseInt(valor) / 100);
        }
    </script>
</body>
</html>