   
    function preencheUF(){
        var uf = ['SP', 'RJ', 'BA', 'CE'];
        var html = '';
        for(var i in uf){
            html += "<option>"+"teste"+"</option>";
        }
        document.getElementById('uf').innerHTML = "<option>"+"SP"+"</option>";
    }
    
    function getCep(){
      if($('#cep').val().length === 8){
          $.ajax({
          url:"https://viacep.com.br/ws/"+$('#cep').val()+"/json/",
          dataType:"json",
          success:function(json){
            $('#logradouro').val(json.logradouro);
            $('#bairro').val(json.bairro);
            $('#localidade').val(json.localidade);
            $('#uf').val(json.uf);
            $('#numero').focus();
          },
          error:function(){
            alert("Error json cep");
          }
        
        });
      }
      else{
        limpaCampos();
      }
    }
    function limpaCampos(){
      $('#logradouro').val('');
      $('#bairro').val('');
      $('#localidade').val('');
      $('#uf').val('');
    }
    