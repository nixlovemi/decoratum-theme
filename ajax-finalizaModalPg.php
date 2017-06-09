<form name="frmFinalizarCompraModal" method="post">
  <div id="compraModal-1" class="compraModal">
  	<table border="0" width="100%" class="tb-finaliza">
    	<tr>
      	<td width="20%">Nome:</td>
        <td><input type="text" name="finaliza-nome" id="finaliza-nome" placeholder="Nome" /></td>
      </tr>
      <tr>
      	<td width="20%">Sobrenome:</td>
        <td><input type="text" name="finaliza-sobrenome" id="finaliza-sobrenome" placeholder="Sobrenome" /></td>
      </tr>
      <tr>
      	<td width="20%">CPF:</td>
        <td><input class="mask-cpf" type="text" name="finaliza-cpf" id="finaliza-cpf" placeholder="CPF" /></td>
      </tr>
      <tr>
      	<td width="20%">Email:</td>
        <td><input type="text" name="finaliza-email" id="finaliza-email" placeholder="Email" /></td>
      </tr>
    </table>
    <span class="spn-btn-finalizar">
    	<input type="button" class="btn btn-pink-cake" onclick="finishNextPage(1);" value="Prosseguir" />
    </span>
  </div>
  <div id="compraModal-2" class="dspl-hddn">
  	<div id="compraModal-2" class="compraModal">
  	<table border="0" width="100%" class="tb-finaliza">
    	<tr>
      	<td width="20%">CEP:</td>
        <td><input class="mask-cep" type="text" name="finaliza-cep" id="finaliza-cep" placeholder="CEP" /><input type="button" style="margin-left:3px; padding:1px !important;" class="btn btn-grey-cake" value="Buscar" /></td>
      </tr>
    </table>
    <table border="0" width="100%" class="tb-finaliza dspl-hddn" id="tb-endereco-completo">
    	<tr>
      	<td width="20%">Endereço:</td>
        <td><input type="text" name="finaliza-endereco" id="finaliza-endereco" placeholder="Endereço" /></td>
      </tr>
      <tr>
      	<td width="20%">Número:</td>
        <td><input type="text" name="finaliza-numero" id="finaliza-numero" placeholder="Número" /></td>
      </tr>
      <tr>
      	<td width="20%">Bairro:</td>
        <td><input type="text" name="finaliza-bairro" id="finaliza-bairro" placeholder="Bairro" /></td>
      </tr>
      <tr>
      	<td width="20%">Cidade:</td>
        <td><input type="text" name="finaliza-cidade" id="finaliza-cidade" placeholder="Cidade" /></td>
      </tr>
    </table>
    <span class="spn-btn-finalizar">
    	<input type="button" class="btn btn-pink-cake" onclick="finishPrevPage(2);" value="Voltar" />
    	<input type="button" class="btn btn-pink-cake" onclick="finishNextPage(2);" value="Prosseguir" />
    </span>
  </div>
  <div id="compraModal-3" class="dspl-hddn">
  
  </div>
</form>