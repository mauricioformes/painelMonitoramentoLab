////////////////////////////////////////////////////////////////////////////////////
///                               Funções JavaScript 	                         ///
///                           Validações de Formulários 	                 ///
///                        Sistemas de Controle de Chamados                      ///
////////////////////////////////////////////////////////////////////////////////////
// -------------------------------------------------------------------------
// Nome da Função      : f_Mascara_AMB
// Analista            : Guilherme Muller Coletti
// Data                : 18-08-2006
// Utilidade           : Função que mascara a digitação de horas nos formulários
// Sintaxe             : f_Mascara_AMB(form1.fcod)
// Exemplo             : f_Mascara_AMB(form1.fcod)
// Data Ult. Alteração :
// Alterações          :
// -------------------------------------------------------------------------

function f_Mascara_AMB(cValor){
	 var mydata = '';
	 mydata = mydata + cValor.value;
	 if (mydata.length == 2){
		mydata = mydata + '.';
		cValor.value = mydata;
	 }
	 if (mydata.length == 5){
		mydata = mydata + '.';
		cValor.value = mydata;
	 }
	 if (mydata.length == 9){
		mydata = mydata + '-';
		cValor.value = mydata;
	 }

}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validar apenas letras
// Analista            : Guilherme M. Coletti
// Data                : 28-06-2002
// Utilidade           : Função que verifica se foi digitado sem espaco
// Sintaxe             : f_ValidarStringSemEspaco(Nome do Campo);
// Exemplo 	       : f_ValidarStringSemEspaco(form1,this);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarStringSemEspaco(cCampo)
{
	cCampo.style.background='#FFFFFF';
	var valid = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"
	var ok = "yes";
	var temp;
	for (var i=0; i<cCampo.value.length; i++)
	{
		temp = "" + cCampo.value.substring(i, i+1);
		if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no")
	{
		alert("Por favor, digite apenas letras sem acentos e nem aspa simples!");
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validar apenas letras
// Analista            : Guilherme M. Coletti
// Data                : 28-06-2002
// Utilidade           : Função que verifica se foi digitado sem acentos
// Sintaxe             : f_ValidarStringAcentos(Nome do Campo);
// Exemplo 	       : f_ValidarStringAcentos(form1,this);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarStringAcentos(cCampo)
{
	cCampo.style.background='#FFFFFF';
	var valid = "qwertyuiopasdfghjklzxcvbnm  QWERTYUIOPASDFGHJKLZXCVBNM"
	var ok = "yes";
	var temp;
	for (var i=0; i<cCampo.value.length; i++)
	{
		temp = "" + cCampo.value.substring(i, i+1);
		if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no")
	{
		alert("Por favor, digite apenas letras sem acentos e nem aspa simples!");
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Carregando
// Analista            : Guilherme M. Coletti
// Data                : 03-04-2006
// Utilidade           :
// Sintaxe             :
// Exemplo 	       :
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------


function HideStatus(){
	//window.status = document.readyState!="complete" ? "Carregando..." : window.defaultStatus;
	//if(document.readyState =="complete"){
		iCarregando.style.display='none';
	//}
}
//document.onreadystatechange = HideStatus;

// ---------------------------------------------------------------------------------
// Nome da Função      : Ajuda
// Analista            : Guilherme M. Coletti
// Data                : 03-04-2006
// Utilidade           :
// Sintaxe             : f_Ajuda(texto)
// Exemplo 	       : f_Ajuda('Digite o Nome')
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_Ajuda(sAjuda){
	top.ajuda.innerHTML=sAjuda;
}

// -------------------------------------------------------------------------
// Nome da Função      : f_MascaraDiaMes
// Analista            : Guilherme Muller Coletti
// Analista            : Ricardo Campos Silva
// Data                : 27-07-2004
// Utilidade           : Função que mascara a digitação de dia e mês nos formulários
// Sintaxe             : f_MascaraDiaMes(form1.fdata)
// Exemplo             : f_MascaraDiaMes(form1.fdata) // se for digitado 0104 irá
// retornar 01/04 no campo do formulário
// Data Ult. Alteração :
// Alterações          :
// -------------------------------------------------------------------------

	 function f_MascaraDiaMes(cValor){
			 var mydata = '';
			 mydata = mydata + cValor.value;
			 if (mydata.length == 2){
			 mydata = mydata + '/';
			 cValor.value = mydata;
			 }
	 }

// -------------------------------------------------------------------------
// Nome da Função      : f_MascaraTelefone
// Analista            : Guilherme M. Coletti
// Data                : 04-03-2008
// Utilidade           : Função que mascara a digitação de telefone
// Sintaxe             : f_MascaraData(form1.fdata)
// Exemplo             : f_MascaraData(form1.fdata) // se for digitado 01042004 irá
// retornar 01/04/2004 no campo do formulário
// Data Ult. Alteração :
// Alterações          :
// -------------------------------------------------------------------------

	 function f_MascaraTelefone(cValor){
			 var mydata = '';
			 mydata = mydata + cValor.value;
			 if (mydata.length == 4){
			mydata = mydata + '-';
			cValor.value = mydata;
			 }
	 }

// -------------------------------------------------------------------------
// Nome da Função      : f_MascaraData
// Analista            : Guilherme M. Coletti
// Data                : 14-03-2004
// Utilidade           : Função que mascara a digitação de datas nos formulários
// Sintaxe             : f_MascaraData(form1.fdata)
// Exemplo             : f_MascaraData(form1.fdata) // se for digitado 01042004 irá
// retornar 01/04/2004 no campo do formulário
// Data Ult. Alteração :
// Alterações          :
// -------------------------------------------------------------------------

	 function f_MascaraData(cValor){
			 var mydata = '';
			 mydata = mydata + cValor.value;
			 if (mydata.length == 2){
	 mydata = mydata + '/';
	 cValor.value = mydata;
			 }
			 if (mydata.length == 5){
	 mydata = mydata + '/';
	 cValor.value = mydata;
			 }
	 }

// -------------------------------------------------------------------------
// Nome da Função      : f_MascaraHora
// Analista            : Guilherme Muller Coletti
// Data                : 04-01-2005
// Utilidade           : Função que mascara a digitação de horas nos formulários
// Sintaxe             : f_MascaraHora(form1.fhora)
// Exemplo        : f_MascaraData(form1.fdata) // se for digitado 01042004 irá
// retornar 01/04/2004 no campo do formulário
// Data Ult. Alteração :
// Alterações          :
// -------------------------------------------------------------------------

	 function f_MascaraHora(cValor){
			 var mydata = '';
			 mydata = mydata + cValor.value;
			 if (mydata.length == 2){
	 mydata = mydata + ':';
	 cValor.value = mydata;
			 }
	 }


// ---------------------------------------------------------------------------------
// Nome da Função      : Validação CheckBox
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função para validar checkboxs nulos
// Sintaxe             : f_ValidarCheckBox(Nome do Form,Nome do Campo,Qtd Indexação);
// Exemplo 	       : Esta função deverá ser usada no final do formulário,
//                       no momento da validação do formulário
//                       return f_ValidarCheckBox(form1,"fOpcao",3);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarCheckBox(cForm,cValor,nQtd)
{
	var cEnc = false;
	for (var x=1;x<nQtd;x++)
	{
		cOpcao = cValor+x;
		if (cForm.elements[cOpcao].checked)
		{
			cEnc = true;
		}
	}
	if (cEnc == false)
	{
		alert("Por favor, preencha o campo obrigatório");
		return false;
	}
	else
	{
		return true;
	}
}


// ---------------------------------------------------------------------------------
// Nome da Função      : Validação Radio Button
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função para validar radio buttons nulos
// Sintaxe             : f_ValidarRadio(Nome do Form.Nome do Campo);
// Exemplo 	       : Esta função deverá ser usada no final do formulário,
//                       no momento da validação do formulário
//                       return f_ValidarRadio(form1.fRadio);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarRadio(cValor)
{
		//cOk  = false;
		//nQtd = $("#"+cValor).length;
		//nQtd=3;

		alert(cValor);

		// for (i=1;i<=nQtd;i++)
		// {
		// 	if ($("#"+cValor+i).prop('checked')=="checked")
		// 	{
		//     	cOk = true;
		//     	break;
		//     }
		// }

		// if (cOk)
		// {
		// 	return true;
		// }
		// else
		// {
		 //   modal_erro("Por favor, preencha o campo obrigatório",0);

		// }
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de Hora
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica sea hora digitada é válida
// Sintaxe             : f_ValidarHora(Nome do Form, Hora);
// Exemplo 	       : Esta função deverá ser usada no final do formulário,
//                       no momento da validação do formulário
//                       return f_ValidarHora(form1,form1.fHora);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarHora( cCampo )
{
		var cHr, cMin;
		cCampo.style.background='#FFFFFF';
		cHr  = cCampo.value.substr( 0,2 );
		cMin = cCampo.value.substr( 3,2 );

		// Verifica se a hora foi digitada corretamente
		if ( ( cCampo.value.substr(2,1) == ':' ) &&
				 ( ( parseInt( cHr  ) >= 0 ) && ( parseInt( cHr  ) <= 23 ) ) &&
				 ( ( parseInt( cMin ) >= 0 ) && ( parseInt( cMin ) <= 59 ) ) )
		{
			return ( true );
		}
		else
		{
			alert( 'Favor fornecer a hora em um formato válido (HH:MM).' );
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}
}


// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de Período
// Analista            : Guilherme M. Coletti
// Data                : 28-06-2002
// Utilidade           : Função que verifica a validade de um período
// Sintaxe             : f_ValidarPeriodo(Nome do Form, Data inicial, Data Final);
// Exemplo 	       : Esta função deverá ser usada no final do formulário,
//                       no momento da validação do formulário
//                       return f_ValidarPeriodo(form1,form1.DtIni, form1.DtFim);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarPeriodo( cForm, cDtIni,cDtFim )
{
		var cDtIniAux, cDtFimAux;

		cDtIniAux = cDtIni.value.substr( 6,4 ) + cDtIni.value.substr( 3,2 ) + cDtIni.value.substr( 0,2 );
		cDtFimAux = cDtFim.value.substr( 6,4 ) + cDtFim.value.substr( 3,2 ) + cDtFim.value.substr( 0,2 );

		if ( cDtIniAux > cDtFimAux )
		{
			alert( 'A data inicial não pode ser posterior à data final do período' );
			return false;
		}
		else
		{
			// Verifica se a quantidade de dias do período é maior que o limite
			// Em implantação


			return true;
		}
}


// ---------------------------------------------------------------------------------
// Nome da Função      : Edição do Campo
// Analista            : Guilherme M. Coletti
// Data                : 28-06-2002
// Utilidade           : Função que verifica se o campo em que a função está sendo chamada
//   	 	         poderá ser editado.
// Sintaxe             : f_EditaCampo(Nome do Form, Nome do Campo);
// Exemplo 	       : <input type=hidden name=feditadata>
//                       <input type=text name=fdata onFocus="return f_EditaCampo(form1,this);">
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_EditaCampo( cForm,cCampo )
{
		nValor = cCampo.name.substr(0,1) + 'edita' + cCampo.name.substr(1)
		if ( cForm.elements[nValor].value == 'N' )
		{
			cCampo.blur();
		}
		return true;
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de Tamanho Mínimo
// Analista            : Guilherme M. Coletti
// Data                : 24-07-2003
// Utilidade           : Função que verifica a quantidade mínima de caracteres digitados em um
//			 determinando objeto do form.
// Sintaxe             : f_ValidarTamanhoMin(Nome do Campo, Maximo de Caracteres)
// Exemplo 	       : f_ValidarTamanhoMin(form1.fcObs,120);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarTamanhoMin(cCampo,nTamanho)
{
	cCampo.style.background='#FFFFFF';
	if ((cCampo.value.length < nTamanho) && (cCampo.value.replace(' ','') != ""))
	{
		alert('O campo deve ter no mínimo ' + nTamanho + ' caracteres!');
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de Tamanho
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica a quantidade de caracteres digitados em um
//			 determinando objeto do form.
// Sintaxe             : f_ValidarTamanho(Nome do Campo, Maximo de Caracteres)
// Exemplo 	       : f_ValidarTamanho(form1.fcObs,120);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarTamanho(cCampo,nTamanho)
{
	cCampo.style.background='#FFFFFF';
	if ((cCampo.value.length > nTamanho) && (cCampo.value.replace(' ','') != ""))
	{
		alert('O campo deve ter apenas ' + nTamanho + ' caracteres!');
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de Data
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : 1 - Função que verifica se a data é valida.
//			 2 - Verifica se a data mais hoje é maior que a data informada
//			 3 - Verifica se a data atual é maior que a data informada
//			 4 - Verifica se a data mais hoje é menor que a data informada
//			 5 - Verifica se a data atual é menor que a data informada
// Sintaxe             : f_ValidarData(Campo do Form);
// Exemplo 	       : f_ValidarData(fcData); --> 1
//			 f_ValidarData(fcData,'HF'); --> 2 não permite data < q atual
//			 f_ValidarData(fcData,'F'); --> 3
//			 f_ValidarData(fcData,'AH'); --> 4 não permite data > q atual
//			 f_ValidarData(fcData,'A'); --> 5
// Data Ult. Alteração :
// ----------------------------------------------------------------------------------

function f_ValidarData( cCampo, cTipo )
{
	cCampo.style.background='#FFFFFF';
	var Data = new Date();
	var dHoje = new Date(Data.getFullYear(),Data.getMonth(),Data.getDate(),0,0,0);
	var nMes, cMes;
	var dDataFornecida;
	var str = cCampo.value;
	var cErro = 'Por favor, digite a data corretamente ( Ex. 14/05/2001 )';

	if (str.replace(' ','') != "")
	{
		// Verifica se foram digitados 10 caracteres.
		if (str.length != 10)
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}
		// Verifica se os caracteres são números e barra.
		for (var i = 0; i < str.length; i++)
		{
			var ch = str.substring(i, i + 1);
			if ((ch < "0" || "9" < ch) && ch != "/")
			{
				alert(cErro)
				cCampo.focus();
				cCampo.style.background='#F67070';
				return false;
			}
		}

		// Verifica o valor do dia.
		if ( (str.substring(0, 2) < 1) || (str.substring(0, 2) > 31) )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}

		// Verifica o valor do dia no valor do mês.
		// Fevereiro
		if ( (str.substring(3, 5) == 2 ) && (str.substring(0, 2) > 29) )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}
		if ( (str.substring(3, 5) == 2 ) && (str.substring(0, 2) == 29) )
		{
			if (!confirm('\nVocê entrou com 29 de Fevereiro...\n\nVocê tem certeza de que é ano bissexto?'))
			{
				cCampo.focus();
							cCampo.style.background='#F67070';
				return false;
			}
		}

		// Abril
		if ( (str.substring(3, 5) == 4 ) && (str.substring(0, 2) > 30) )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}

		// Junho
		if ( (str.substring(3, 5) == 6 ) && (str.substring(0, 2) > 30) )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}

		// Setembro
		if ( (str.substring(3, 5) == 9 ) && (str.substring(0, 2) > 30) )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';

			return false;
		}

		// Novembro
		if ( (str.substring(3, 5) == 11 ) && (str.substring(0, 2) > 30) )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}

		// Verifica o valor do mês.
		if ( (str.substring(3, 5) < 1) || (str.substring(3, 5) > 12) )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}


		// Verifica posicionamento da barra.
		if ( str.substring(3, 4) == "/" || str.substring(4, 5) == "/" )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}

		if ( str.substring(0, 1) == "/" || str.substring(1, 2) == "/" )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}

		if ( str.substring(6, 9) == "/" || str.substring(7, 10) == "/" )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}

		if ( str.substring(2, 3) != "/" || str.substring(5, 6) != "/" )
		{
			alert(cErro)
			cCampo.focus();
			cCampo.style.background='#F67070';
			return false;
		}


		// Verifica se a data é anterior a hoje
		nMes = str.substring(3,5) - 1;

		dDataFornecida = new Date( str.substring(6,10), nMes, str.substring(0,2) );

		if ( toString( dDataFornecida.getMonth() ).lenght  < 2 )
		{
			cMes = "0" + toString( dDataFornecida.getMonth() );
		}
		else
		{
			cMes = toString( dDataFornecida.getMonth() );
		}

		if (cTipo == "F")
		{
			if ( dDataFornecida <=  dHoje )
			{
				alert("\nA Data não pode ser menor que a Data de Hoje!");
				cCampo.focus();
				cCampo.style.background='#F67070';
				return false;
			}
		}
		else if (cTipo == "A")
		{
			if ( dDataFornecida >=  dHoje )
			{
				alert("\nA Data não pode ser maior que a Data de Hoje!");
				cCampo.focus();
				cCampo.style.background='#F67070';
				return false;
			}
		}
		else if (cTipo == "HF")
		{
			if ( dDataFornecida <  dHoje )
			{
				alert("\nA Data não pode ser menor que a Data de Hoje!");
				cCampo.focus();
				cCampo.style.background='#F67070';
				return false;
			}
		}
		else if (cTipo == "AH")
		{
			if ( dDataFornecida >  dHoje )
			{
				alert("\nA Data não pode ser maior que a Data de Hoje!");
				cCampo.focus();
				cCampo.style.background='#F67070';
				return false;
			}
		}
	return true;
	}
	else
	{
	 return true;
	}

}


// ---------------------------------------------------------------------------------
// Nome da Função      : Validar apenas caracteres
// Analista            : Guilherme M. Coletti
// Data                : 28-06-2002
// Utilidade           : Função que verifica se foi informado apenas letras no campo
// Sintaxe             : f_ValidarString(Nome do Campo);
// Exemplo 	       : f_ValidarString(form1,this);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarString(cCampo)
{
	cCampo.style.background='#FFFFFF';
	var valid = "aàáãâbcdeéêfghiíìjklmnoôõpqrstuvwxyz' AÀÁÃÂBCÇDEÉÊFGHÌÍIJKLMNOÔÕPQRSTUVWXYZ"
	var ok = "yes";
	var temp;
	for (var i=0; i<cCampo.value.length; i++)
	{
		temp = "" + cCampo.value.substring(i, i+1);
		if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no")
	{
		alert("Por favor, digite apenas letras!");
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validar apenas caracteres e numeros
// Analista            : Guilherme Muller Coletti
// Data                : 23-09-2004
// Utilidade           : Função que verifica se foi informado apenas letras e numero no campo
// Sintaxe             : f_ValidarAlfanumerico(Nome do Campo);
// Exemplo 	       : f_ValidarAlfanumerico(form1,this);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarAlfanumerico(cCampo)
{
	cCampo.style.background='#FFFFFF';
	var valid = "'aàáãâbcdeéêfghiíìjklmnoôõpqrstuvwxyz AÀÁÃÂBCÇDEÉÊFGHÌÍIJKLMNOÔÕPQRSTUVWXYZ 1234567890 -"
	var ok = "yes";
	var temp;
	for (var i=0; i<cCampo.value.length; i++)
	{
		temp = "" + cCampo.value.substring(i, i+1);
		if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no")
	{
		alert("Por favor, digite apenas letras ou numeros!");
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}
// ---------------------------------------------------------------------------------
// Nome da Função      : Validar apenas caracteres e numeros
// Analista            : Guilherme Muller Coletti
// Data                : 23-09-2004
// Utilidade           : Função que verifica se foi informado apenas letras e numero no campo
// Sintaxe             : f_ValidarAlfanumerico(Nome do Campo);
// Exemplo 	       : f_ValidarAlfanumerico(form1,this);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarAlfanumericosemaspa(cCampo)
{
	cCampo.style.background='#FFFFFF';
	var valid = "aàáãâbcdeéêfghiíìjklmnoôõpqrstuvwxyz AÀÁÃÂBCÇDEÉÊFGHÌÍIJKLMNOÔÕPQRSTUVWXYZ 1234567890 -."
	var ok = "yes";
	var temp;
	for (var i=0; i<cCampo.value.length; i++)
	{
		temp = "" + cCampo.value.substring(i, i+1);
		if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no")
	{
		alert("Por favor, digite apenas letras ou numeros, menos aspas simples!");
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}
// ---------------------------------------------------------------------------------
// Nome da Função      : Validar apenas caracteres e numeros
// Analista            : Guilherme Muller Coletti
// Data                : 23-09-2004
// Utilidade           : Função que verifica se foi informado código amb
// Sintaxe             : f_ValidarCodAmB(Nome do Campo);
// Exemplo 	       : f_ValidarCodAmB(form1,this);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarCodAmB(cCampo)
{
	cCampo.style.background='#FFFFFF';
	var valid = "1234567890 - ."
	var ok = "yes";
	var temp;
	for (var i=0; i<cCampo.value.length; i++)
	{
		temp = "" + cCampo.value.substring(i, i+1);
		if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no")
	{
		alert("Por favor, digite apenas numeros!");
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de Número Reais
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica se o valor do campo informado é um numero real
//			 Ex: 1.25  1,25
// Sintaxe             : f_ValidarNumeroReal(Nome do Campo, cSep);
// Exemplo 	       : f_ValidarNumeroReal(form1,this);
// Data Ult. Alteração :
// Alterações          : Inclusão do parâmetro cSep, que indica qual separador
//                       deverá ser considerado (vírgula ou ponto ).
// ----------------------------------------------------------------------------------


function f_ValidarNumeroReal(nNumero, cSep)
{
	nNumero.style.background='#FFFFFF';
	var x=nNumero.value
	var cFiltroVirgula=/(^\d+$)|(^\d+\,\d+$)/
	var cFiltroPonto=/(^\d+$)|(^\d+\.\d+$)/
	var cFiltro

	if ( cSep == "," )
	{
		cFiltro = cFiltroVirgula;
	}
	else
	{
		cFiltro = cFiltroPonto;
	}

	if ((!cFiltro.test(x)) && (nNumero.value.replace(' ','') != ""))
	{
		if ( cSep == "," )
		{
			alert("Por favor, preencha um número válido! ( Somente Algarismos e Vírgula )");
		}
		else
		{
			alert("Por favor, preencha um número válido! ( Somente Algarismos e Ponto )");
		}

		nNumero.focus();
		nNumero.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de Número Inteiro
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica se o valor do campo é um Numero Inteiro
//   	 	         Ex. 20
// Sintaxe             : f_ValidarNumeroInteiro(Nome do Campo);
// Exemplo 	       : f_ValidarNumeroInteiro(form1,this);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarNumeroInteiro(nNumero)
{
	nNumero.style.background='#FFFFFF';
	var x=nNumero.value
	var cFiltro=/(^\d+$)|(^\d+\\d+$)/
	if ((!cFiltro.test(x)) && (nNumero.value.replace(' ','') != ""))
	{
		alert("Por favor, use somente números!");
		nNumero.focus();
			nNumero.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de Campo Nulos
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica se o valor do campo é nulo
// Sintaxe             : f_ValidarCamposNulos(Nome do Campo);
// Exemplo 	       : f_ValidarCamposNulos(form.nome do campo);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarCamposNulos(cCampo)
{
 //alert(cCampo +" : "+$("#"+cCampo).val());
	//cCampo.style.background='#FFFFFF';
	if ($("#"+cCampo).val().length<=0)
	{

		$("#"+cCampo).css('background', '#F67070');
		modal_erro("Por favor, preencha o campo obrigatório");

		$("#"+cCampo).focus();
		alert(cCampo+" falhou");
		return false;
	}
	else
	{
		alert(cCampo+" ok");
		return true;
	}
}


// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de E-mail
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica se o e-mail informada é válido
// Sintaxe             : f_ValidarEmail(Nome do Campo);
// Exemplo 	       : f_ValidarEmail(form1,this);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarEmail(cEmail)
{
	cEmail.style.background='#FFFFFF';
	var str=cEmail.value
	var cFiltro=/^.+@.+\..{1,3}$/
	if ((!cFiltro.test(str)) && (cEmail.value.replace(' ','') != ""))
	{
		alert("Por favor, insira um e-mail válido!")
		cEmail.focus();
		cEmail.style.background='#F67070';
		return false;
	}
	else
	{
		return true;
	}
}

// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de N Campos Obrigatórios
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica se o usuário preencheu pelo menos N campos
//			 em um formulário.
// Sintaxe             : f_ValidarUmCampo(Nome do Form,Qtd de Campo Necessários,Nome dos Campos);
// Exemplo 	       : f_ValidarUmCampo("form1",2,new Array ("campo1","campo2","campo3"));
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarUmCampo(cForm,nQtd,cCampo)
{
	var cErro = 0;
	for (x=0;x<cCampo.length;x++)
	{
		campo = cCampo[x];
		if (top.aplic_centro.document.forms[cForm].elements[campo].value.replace(' ','') != "")
		{
			cErro++;
		}
	}
	if (cErro < nQtd)
	{
		alert('Por favor, você precisa preencher pelo menos ' + nQtd + ' dos campos descritos!');
	}
	else
	{
		return true;
	}
}


// ---------------------------------------------------------------------------------
// Nome da Função      : Validação de N Campos Obrigatórios para telefone
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica se o usuário preencheu pelo menos N campos
//			 em um formulário.
// Sintaxe             : f_ValidarUmCampo(Nome do Form,Qtd de Campo Necessários,Nome dos Campos);
// Exemplo 	       : f_ValidarUmCampo("form1",2,new Array ("campo1","campo2","campo3"));
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarUmCampoTel(cForm,nQtd,cCampo)
{
	var cErro = 0;
	for (x=0;x<cCampo.length;x++)
	{
		campo = cCampo[x];
		if (top.document.forms[cForm].elements[campo].value.replace(' ','') != "")
		{
			cErro++;
		}
	}
	if (cErro < nQtd)
	{
		alert('Por favor, você precisa preencher pelo menos um dos campos telefone!');
	}
	else
	{
		return true;
	}
}


// ---------------------------------------------------------------------------------
// Nome da Função      	: Validação Nome Abreviado
// Analista            	: Guilherme M. Coletti
// Data                	: 27-06-2002
// Utilidade           	: Função que verifica se o nome esta abreviado
// Sintaxe             	: f_ValidarNomeAbr(Nome do Form);
// Exemplo 	       		: f_ValidarNomeAbr(form1.fnome);
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------
function f_ValidarNomeAbr(cCampo)
{
	cCampo.style.background='#FFFFFF';
	var frase    = cCampo.value;
	var frase2   = frase.split(" ");
	var tamanho  = frase.length;
	var totalarr = frase2.length;
	var erro     = 0;

	if(frase.indexOf(". ") != -1){
		alert('Não pode conter nome abreviado');
		cCampo.style.background='#F67070';
		cCampo.focus();
		erro = 1;
		return false;
	}
	if(frase.indexOf(".") != -1){
		alert('Não pode conter nome abreviado');
		cCampo.style.background='#F67070';
		cCampo.focus();
		erro = 1;
		return false;
	}
	if(frase.indexOf("  ") != -1){
		alert('Não pode conter dois espaço em branco');
		cCampo.style.background='#F67070';
		cCampo.focus();
		erro = 1;
		return false;
	}
	var qtd = frase.split(" ");
	if( (qtd.length == 1) && (frase != "e" && frase != "E") ){
		alert('Não pode conter nome abreviado');
		cCampo.style.background='#F67070';
		cCampo.focus();
		erro = 1;
		return false;
	}


	//if(frase.slice(-1).indexOf(" ") != -1){
	//	alert('Não pode conter nome abreviado');
	//	cCampo.style.background='#F67070';
	//	cCampo.focus();
	//	erro = 1;
	//	return false;
	//}

	for(i=0;i<=totalarr - 1;i++){
		if(frase2[i].length == 1){
			alert('Não pode conter nome abreviado');
			cCampo.style.background='#F67070';
			cCampo.focus();
			erro = 1;
			return false;
		}
		if( (frase2[i].length == 2) && (frase2[i].toLowerCase() == "jr") ){
			alert('Não pode conter nome abreviado');
			cCampo.style.background='#F67070';
			cCampo.focus();
			erro = 1;
			return false;
		}
	}
	if(erro == 0){
		return true;
	}
}



// ---------------------------------------------------------------------------------
// Nome da Função      : f_ValidarPlaca
// Analista            : Guilherme M. Coletti
// Data                : 27-06-2002
// Utilidade           : Função que verifica se uma placa de automóvel foi digitada corretamente
// Sintaxe             : f_ValidarString(Nome do Campo, Máscara);
// Exemplo 	       : f_ValidarString(form1.fPlaca, '-');
//                       Observação : se o 2º parâmetro for omitido, significa que a
//                       máscara não faz parte da informação. e não deverá ser validada
// Data Ult. Alteração :
// Alterações          :
// ----------------------------------------------------------------------------------

function f_ValidarPlaca(cCampo, cMascara)
{
	cCampo.style.background='#FFFFFF';
	var aLetras  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
	var aNumeros = "0123456789"
	var ok = "yes";
	var temp;
	var cMsgAdic;
	var nPosIniNr;

	// Valida a máscara e define a mensagem adequada para ser mostrada em caso de erro
	if ( cMascara == "-" )
	{ cMsgAdic = ',\n separados por traço (-)';
		if ( cCampo.value.substr(3,1) != '-' ) ok = "no";
		nPosIniNr = 4;
	}
	else
	{ cMsgAdic = '';
		nPosIniNr = 3;
	}

	// valida as letras
	for (var i=0; i<=2; i++)
	{
		if (aLetras.indexOf(cCampo.value.substr(i,1)) == -1){ ok = "no"};
	}
	if (ok == "no")
	{
		alert("A placa deve ser informada com 3 letras e 4 números" + cMsgAdic);
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}

	// valida os números
	ok = "yes";
	for (var i=nPosIniNr; i<cCampo.length; i++)
	{
		temp = "" + cCampo.value.substring(i, i+1);
		if (aNumeros.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no")
	{
		alert("A placa deve ser informada com 3 letras e 4 números" + cMsgAdic);
		cCampo.focus();
		cCampo.style.background='#F67070';
		return false;
	}
	else { return true; }
}


/**
* @return Date
*/
function getDataAtualSemHorario() {
	var today = new Date();
	return new Date(today.getFullYear(), today.getMonth(), today.getDate(), 0, 0, 0, 0);
}


 /**
*
*@param string
*@return Date
*/
function converteStringToDate(strDate) {
	if (strDate && strDate.length > 0)
		return new Date(strDate.replace(/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/i,"$2/$1/$3"));
	else
		return null;
}

function hasFlash() {
	var hasFlash = false;
	try {
		var fo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
		if(fo) hasFlash = true;
	}catch(e){
		if(navigator.mimeTypes ["application/x-shockwave-flash"] != undefined) hasFlash = true;
	}
	return hasFlash;
}

/**
*
* @param string
*/
function isMaiorQueDataAtual(strData) {
	var dataAtual     = getDataAtualSemHorario();
	var dataInformada = converteStringToDate(strData);

	return dataInformada > dataAtual;
}

function validaData(strData) {
	if (isMaiorQueDataAtual(strData)) {
		alert("\nA Data não pode ser maior que a Data de Hoje!");
		return false;
	}
	return true;
}

Date.prototype.menorQue = function (data) {
	if (typeof data == "string")
		date = converteStringToDate(data);
	else
		date = data;
	return this < date;
}


Date.prototype.maiorQue = function (data) {
	if (typeof data == "string")
		date = converteStringToDate(data);
	else
		date = data;
	return this > date;
}

Date.prototype.igualA = function (data) {
	return this == converteStringToDate(data);
}

String.prototype.toDate = function() {
	return converteStringToDate(this);
}


/* ---------------------------------------------------------------------------------
// Nome da Função      	: Validação de N Campos Obrigatórios
// Analista            	: Nelson Imon
// Data                	: 09/06/2014
// Utilidade           	: Função que verifica se o usuário preencheu pelo menos N camposem um formulário.

// Sintaxe             	: validarCampos("campo1,campo2,campo3,[sexo_m;sexo_f],@form1");
							campo1,campo2,campo3 - > id dos inputs ou selects
							[sexo_m;sexo-f] -> id do radio name="sexo"
							@form1 - > id do formulario

// Exemplo 	       		: $("#comunicar").click(function(){
								 validarCampos("campo1,campo2,campo3,[sexo_m;sexo_f],@form1");
							});

// Data Ult. Alteração 	:
// Alterações          	:

// 						http://jsfiddle.net/CHe6z/1/

// Arquivos				: app/solcons/index.php
 ----------------------------------------------------------------------------------  */

function f_validarCampos(campos)
{
		//cria variaveis estanciadas
		var mensagem=0;
		var formulario="";

		//separa os argumentos da funcao
		inputs=campos.split(",");

		//verifica o total de argumentos para percorrer no FOR
		total=inputs.length;

		for(i=0;i<total;i++)
		{
				//se o argumento comeca com @ -> id do formulario para dar submit
				if(inputs[i][0]=="@")
				{
						//atribuio o argumento a variavel submit
						formulario=inputs[i].replace("@","");
				}
				else
				{
						//se o argumento comecar com [ -> verifcar OU dos radios ou inputs
						if(inputs[i][0]=="[")
						{
								//separa os argumentos entre []
								inputou=inputs[i].replace("[","").replace("]","");

								//separa os argumentos alternativos OU
								alternative=inputou.split(";");

								//total dos alternativos para o FOR
								total_alternative = alternative.length;

								//cria variaveis estanciadas
								var escolha=0;

								for(j=0;j<total_alternative;j++)
								{
									 //verifica se o campo foi checked
									 valor_campo=$("#"+alternative[j]+":checked").val();

									 //se o campo for chekced entao é diferente de "undefined" -> atribui valor no campo escolha
									 if(typeof valor_campo !="undefined")
									 {
											escolha++;
									 }


								}

							 //se escolha foi atribuida algo o usuario escolheu alguma das opcoes senão atribui valor na variavel mensagem e marca o campo com erro
							 if(parseInt(escolha)==0)
							 {
										mensagem++;
									 //marcando erro
										//$("#"+alternative[0]+"").parent().css("background","red");
										$("#"+alternative[0]+"").nextAll().remove();
										$("#"+alternative[0]+"").parent().append('<label class="error"><small>Obrigatório</small></label>');
							 }
							 else
							 {
									 //limpa erro
									 //$("#"+alternative[0]+"").parent().css("background","white");
									 $("#"+alternative[0]+"").nextAll().remove();
							 }

						}
						else //fim do if para verificar se o argumento é campo ou alternativo
						{
								//se o valor do argumento for vazio marca o erro e atribui valor a variavel mensagem senao limpa o erro
								if($("#"+inputs[i]+"").val()=="")
								{
										//marca o erro
										//$("#"+inputs[i]+"").css("background","red");
										if($("#"+inputs[i]+"_chosen").length>0)
										{
											$("#"+inputs[i]+"_chosen").nextAll().remove();
											$("#"+inputs[i]+"_chosen").parent().append('<label class="error"><small>Obrigatório</small></label>');
										}
										else
										{
											$("#"+inputs[i]+"").nextAll().remove();
											$("#"+inputs[i]+"").parent().append('<label class="error"><small>Obrigatório</small></label>');
										}
										mensagem++;


								}
								else
								{
										//limpa o erro
										//$("#"+inputs[i]+"").css("background","white");
										if($("#"+inputs[i]+"_chosen").length>0)
										{
											$("#"+inputs[i]+"_chosen").nextAll().remove();
										}
										else
										{
											$("#"+inputs[i]+"").nextAll().remove();	
										}
										
								}
						}
				}

		}

		//se algo foi atribuido na variavel de mensagem entao ouve erro -> mostra mensagem,
		//senao da submit no campo da variavel formulariod
		if(mensagem>0)
		{
				modal_erro("Atenção!","Preencha os campos obrigatórios.");

				return 'false';
		}
		else
		{
				//verifica se o existe o argumento formulario para dar o submit
				if(formulario!=false)
				{
						$("#"+formulario+"").submit();

						//validação para quimio - jprioli 20/02/2015
						//desabilita botão para não requisitar vários anexos de uma vez
						$("#comunicar").attr("disabled", "true");
				}
				return 'true';
		}
}


/* ---------------------------------------------------------------------------------
// Nome da Função      	: f_SomenteNumero
// Analista            	: Nelson Imon
// Data                	: 22/07/2014
// Utilidade           	: Função que permite a entrada apenas de numeros em campos input e textarea.

// Sintaxe             	: onkeypress='return f_SomenteNumero(event)'

// Exemplo 	       	: <input type='text' size='10' value='' onkeypress='return f_SomenteNumero(event)'>

// Data Ult. Alteração 	:
// Alterações          	:

// Fiddle			: http://jsfiddle.net/WLvLJ/

// Arquivos			: app/solcons/index.php
 ----------------------------------------------------------------------------------  */
function f_SomenteNumero(e){
	var tecla=(window.event)?event.keyCode:e.which;
	if((tecla>47 && tecla<58)) return true;
	else{
		if (tecla==8 || tecla==0) return true;
		else return false;
	}
}

function validateInt(evt) {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]/;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

function validateFloat(evt) {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\,/;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

function validateChar(evt) {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	//console.log(key);
	var regex = /[a-z,A-Z,0-9,\b]| /;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}