$(document).ready(function () {
  $('.data').mask('99/99/9999')
  $('#form-calculadora').submit(function (e) { 
    e.preventDefault();
    
    $('.alert').addClass('d-none');
    $('#botaoCalcular').html('Carregando...');
    $('#botaoCalcular').prop('disabled', true);
    
    const dados = {
      dataInicio: $('#dataInicio').val(),
      dataFim: $('#dataFim').val(),
    }
    
    $.getJSON('/calculaDiasUteis.php', dados, function(retorno) {
      $('#botaoCalcular').html('Calcular');
      $('#botaoCalcular').prop('disabled', false);

      if (retorno.sucesso) {
        let textoSucesso = '<b>' + retorno.diasUteis + '</b> dias úteis entre as datas ';
        textoSucesso += dados.dataInicio + ' e ' + dados.dataFim;
        
        $('.alert-primary').html(textoSucesso);
        $('.alert-primary').removeClass('d-none');
      } else {
        $('.alert-danger').html(retorno.mensagem);
        $('.alert-danger').removeClass('d-none');
      }
    })
  });
});