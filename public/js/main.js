$(document).ready(function () {
    $('#cpf').mask('000.000.000-00');
    $('#rg').mask('00.000.000-0');
    $('#phone').mask('(00) 00000-0000');
    $('#postal_code').mask('00.000-000');

    $('#postal_code').on('blur', function () {
        var postalCode = $(this).val().replace(/\D/g, ''); // Remove caracteres especiais

        if (postalCode) {
            $.ajax({
                url: `https://viacep.com.br/ws/${postalCode}/json/`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data && !data.erro) {
                        $('#street').val(data.logradouro);
                        $('#neighborhood').val(data.bairro);
                        $('#city').val(data.localidade);
                        $('#state').val(data.uf);
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: "Atenção",
                            text: "CEP não encontrado. Verifique o CEP e tente novamente.",
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: "Não foi possível consultar o CEP. Tente novamente mais tarde.",
                    });
                }
            });
        }
    });


    // Manipulador de clique para o botão "Deletar"
    $('.delete-address').on('click', function (e) {
        e.preventDefault();

        // Confirmação de exclusão
        Swal.fire({
            title: "Tem certeza que deseja remover o endereço?",
            text: "Você não poderá reverter isso",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, remover!",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Obtém o ID do endereço a partir do data-id
                var addressId = $(this).data('id');
                var row = $('#address-' + addressId);

                // Envia a solicitação Ajax
                $.ajax({
                    url: '/kabum/address/delete/' + addressId,
                    type: 'POST',
                    data: { id: addressId },
                    success: function (response) {
                        // Se a remoção foi bem-sucedida, remova a linha da tabela
                        row.remove();
                        Swal.fire({
                            title: "Removido!",
                            text: "Endereço removido com sucesso.",
                            icon: "success"
                        });
                        // location.reload();
                    },
                    error: function (err) {
                        console.log(err);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Erro ao remover o endereço. Por favor, tente novamente.",
                        });
                    }
                });
            }
        });
    });
});

$(document).ready(function () {
    // Manipulador de clique para o botão "Deletar"
    $('.delete-client').on('click', function (e) {
        e.preventDefault();

        // Confirmação de exclusão
        Swal.fire({
            title: "Tem certeza que deseja remover?",
            text: "Você não poderá reverter isso",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, remover!",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Obtém o ID do cliente a partir do data-id
                var clientId = $(this).data('id');
                var row = $('#client-' + clientId);

                // Envia a solicitação Ajax
                $.ajax({
                    url: '/kabum/clients/delete/' + clientId,
                    type: 'POST',
                    data: { id: clientId },
                    success: function (response) {
                        console.log(response);
                        // Se a remoção foi bem-sucedida, remova a linha da tabela
                        row.remove();
                        Swal.fire({
                            title: "Removido!",
                            text: "Cliente removido com sucesso.",
                            icon: "success"
                        });
                        location.reload();
                    },
                    error: function (err) {
                        console.log(err);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Erro ao remover o cliente. Por favor, tente novamente.",
                        });
                    }
                });
            }
        });
    });
});