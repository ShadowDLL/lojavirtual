window.onload = function(){
   //Ao carregar a página vai iniciar a sessão para envio
   PagSeguroDirectPayment.setSessionId(sessionId);
};
function selectPg(){
    var pgCode = document.getElementById('pg_form').value;
    if (pgCode === "CREDIT_CARD") {
        //Retorna os tipos de pagamentos disponíveis
        PagSeguroDirectPayment.getPaymentMethods({
            amount:valor,
            success:function(json){
                var cartoes = json.paymentMethods.CREDIT_CARD.options;
                var cartoesDisponiveis = ['VISA', 'MASTERCARD', 'AMEX', 'HIPERCARD'];
                var html = "";
                
                for(var i in cartoesDisponiveis){
                    if (cartoes[cartoesDisponiveis[i]].status === "AVAILABLE") {
                       html += "<img onclick='selecionarBandeira(this)' data-bandeira='"+cartoes[cartoesDisponiveis[i]].name+"' src='https://stc.pagseguro.uol.com.br"+cartoes[cartoesDisponiveis[i]].images.MEDIUM.path+"' border='0'/>";
                    }
                }
                
                document.getElementById("bandeiras").innerHTML = html;
                document.getElementById("cc").style.display = "block";
            },
            error:function(e){console.log(e)}
        });
    }
    
}
function selecionarBandeira(obj){
    var bandeira = obj.getAttribute('data-bandeira');
    document.getElementById('bandeira').value = bandeira.toLowerCase();
    document.getElementById('bandeiras').innerHTML = obj.outerHTML;//conteúdo do objeto
    //Retorna as opções de pagamento
    PagSeguroDirectPayment.getInstallments({
        amount:valor,
        brand:bandeira.toLowerCase(),
        success:function(json){
            var parcelamentos = json.installments[bandeira.toLowerCase()];
            var options = '';     
            for(var i in parcelamentos){
                var juros = (parcelamentos[i].interestFree)?"Sem juros":"Com juros";
                var frase = parcelamentos[i].quantity+'x de R$ '+parcelamentos[i].installmentAmount+" ("+juros+")";
                options += '<option value="'+parcelamentos[i].quantity+';'+parcelamentos[i].installmentAmount+';'+parcelamentos[i].interestFree+'">'+frase+'</option>';
            }
            document.getElementById('parc').innerHTML = options;
            document.getElementById('cardinfo').style.display = "block";
        },
        error:function(e){console.log(e);}
    });
   
}

function pagar(){
    if (!formOk) {
       var pgCode = document.getElementById('pg_form').value;
       document.getElementById('shash').value = PagSeguroDirectPayment.getSenderHash(); 
        if (pgCode === "CREDIT_CARD") {
            var cartao = document.getElementById('cartao').value;
            var bandeira = document.getElementById('bandeira').value;
            var cvv = document.getElementById('cvv').value;
            var validade = document.getElementById('validade').value.split('/');
            
            PagSeguroDirectPayment.createCardToken({
                cardNumber:cartao,
                brand:bandeira,
                cvv:cvv,
                expirationMonth:validade[0],
                expirationYear:validade[1], 
                success:function(json){
                    var token = json.card.token;
                    document.getElementById('ctoken').value = token;
                    formOk = true;
                    document.getElementById('form').submit();
                },
                error:function(e){console.log(e);}
            });
            return false;//Para não enviar o formulário
        }
    }
    return true;
}

















