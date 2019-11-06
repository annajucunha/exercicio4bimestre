<!DOCTYPE html>
<html lang>
    <head>
    <style>
       fieldset
        {
            width:600px;
            text-align:center;
           
        }
        table
        {
            
            align-items: center;
            margin-left:50px;

           
        }
        
    </style>

    <meta charset = "utf-8"/>
    <script src = "jquery-3.4.1.min.js"></script>

    
     
    <?php
    include("conexao.php");
    $consulta_cidade = "SELECT * FROM cidade INNER JOIN estado ON cidade.cod_estado = estado.id_estado";
    $resultado_cidade = mysqli_query($conexao,$consulta_cidade) or die ("Erro");
    ?> 




    <script>

        var id = null;
        var filtro = null;

        // PAI DE TODOS -----------------------------------------------------------------------------------
        $(function(){
            
            paginacao(0);
            
            //ALTERAR------------------------------------------------------------------------------------
            $(document).on("click",".alterar",function()
            {
                id = $(this).attr("value");
                $.ajax({
                    url:"carrega_cadastro_alterar.php",
                    type:"post",
                    data:{id: id},
                    success: function(vetor)
                    {
                        $("input[name='nome']").val(vetor.nome);
                        $("input[name='email']").val(vetor.email);
                        $("input[name='salario']").val(vetor.salario);
                        $("select[name='cod_cidade']").val(vetor.cod_cidade);
                        if(vetor.sexo=="f")
                        {
                            $("input[name='sexo'][value='m']").attr("checked",false);
                            $("input[name='sexo'][value='f']").attr("checked",true);
                        }
                        else
                        {
                            $("input[name='sexo'][value='f']").attr("checked",false);
                            $("input[name='sexo'][value='m']").attr("checked",true);   
                        }
                        $(".btn_cadastra").attr("class","alteracao"); // muda o nome do botao cadastrar para Alterar
                        $(".alteracao").val("Alterar Cadastro");
                    }
                });
            
            });

            //PAGINACAO-----------------------------------------------------------------------------------
            function paginacao(p)
            {
                //console.log(p);
                $.ajax(
                {
                    url:"carrega_cadastro.php",
                    type:"post",
                    data:{pg:p, nome_filtro: filtro},
                    success:function(matriz)
                    {
                       // console.log(matriz);
                        $("#tb").html("");
                        for (i=0;i<matriz.length;i++)
                        {
                            linha = "<tr>";
                            linha += "<td class = 'nome'>" + matriz[i].nome + "</td>";
                            linha += "<td class = 'email'>" + matriz[i].email + "</td>";
                            linha += "<td class = 'sexo'>" + matriz[i].sexo + "</td>";
                            linha += "<td class = 'salario'>" + matriz[i].salario + "</td>";
                            linha += "<td class = 'nome_cidade'>" + matriz[i].nome_cidade + "</td>";
                            linha += "<td class = 'nome_cidade'>" + matriz[i].uf + "</td>";
                            linha += "<td><button type = 'button'  class = 'alterar'value='"+ matriz[i].id_cadastro + "'>Alterar</button> <button type = 'button' class = 'remover' value ='" + matriz[i].id_cadastro + "'>Remover</button> </td>";
                            linha += "</tr>";
                            $("#tb").append(linha);
                        }
                    }
                });
            }
                    

            // CLICAR NA PAGINACAO -----------------------------------------------------------------------
            $(document).on("click",".pg",function(){                                                       
                p = $(this).val();
                p = (p-1)*5;
                paginacao(p);   
            });

            // CADASTRAR ---------------------------------------------------------------------------------
            $(document).on("click",".btn_cadastra",function(){
            
                linha = $(this).closest("tr");
                $.ajax
					({
						url:"insere.php",
						type:"post",
						data:
						{
							nome: $("input[name='nome']").val(),
							email:$("input[name='email']").val(),
                            salario:$("input[name='salario']").val(),
                            sexo:$("input[name='sexo']:checked").val(),
                            cod_cidade:$("select[name='cod_cidade']").val()
						},
						
						success:function(data)
						{
							if(data==1)
							{
								$("#status").html("Usuario inserido");
                                $("#status").css("color","pink");
                                paginacao(0);
								
								qtd_linha = $("#tb tr").length;
								qtd_coluna = $("#tb td").length;

								if(qtd_linha == 0 && qtd_coluna == 0)
								{
									linha = "<tr><td colspan = '6'> Não há pessoas cadastradas</td></tr>";
									$("#tb").append(linha);
								}
							}
							else
							{
                                console.log(data);
								$("#status").html("ERRO");
								$("#status").css("color","red");
							}
						},
						error:function(e)
						{
							$("#status").html("ERRO: Sistema indisponivel!");
							$("#status").css("color","red");
						}
					});

            });

        // ALTERACAO -------------------------------------------------------------------------------------
        $(document).on("click",".alteracao",function(){           

                $.ajax(
                {
                    url:"alteracao_cadastro.php",
                    type:"post",
                    data:
                    {
                        id: id,
                        nome: $("input[name='nome']").val(),
                        email:$("input[name='email']").val(),
                        salario:$("input[name='salario']").val(),
                        sexo:$("input[name='sexo']:checked").val(),
                        cidade:$("select[name='nome_cidade']").val(),
                    },
                    success:function(data)
                    {
                        if(data==1)
                        {
                            $("#status").html("Usuario alterado");
                            $("#status").css("color","blue");
                            paginacao(0);
                            $("input[name='nome']").val("");
                            $("input[name='email']").val("");
                            $("input[name='salario']").val("");
                            $("input[name='sexo'] [value='m']").attr("checked",false);
                            $("input[name='sexo'] [value='f']").attr("checked",false);
                            $("select[name='nome_cidade']").val("");

                            $(".alteracao").attr("class","btn_cadastra"); // muda o nome devolta para cadastrar
                            $(".btn_cadastra").val("Cadastrar");  
                        }
                        else
                        {
                            $("#status").html(data);
                            $("#status").css("color","red");
                        }
                    }
                });
            });
            // ALTERAR O NOME ------------------------------------------------------------------------------ 
            $(document).on("click",".nome",function(){    
                
                td= $(this);
                nome= td.html();
                td.html("<input type='text' id='nome_alterar' name='nome' value='" + nome +"' />");
                td.attr("class","nome_alterar");
                
            });  

            // ALTERAR O NOME AO SAIR DO CAMPO -----------------------------------------------------------------
            $(document).on("blur",".nome_alterar",function(){    
                td = $(this).closest("td");
                id_linha= $(this).closest("tr").find("button").val();
                $.ajax({
                    url:"alterar_coluna.php",
                    type:"post",
                    data:{
                            coluna:'nome',
                            valor:$("#nome_alterar").val(),
                            id:id_linha
                         },
                    success: function()
                    {
                        td.html($("#nome_alterar").val());
                        td.attr("class","nome");
                    }
                });
               
            }); 

            // ALTERAR O EMAIL ------------------------------------------------------------------------------  

            $(document).on("click",".email",function(){    
                
                td= $(this);
                email= td.html();
                td.html("<input type='text' id='email_alterar' name='email' value='" + email +"' />");
                td.attr("class","email_alterar");
                
            });  

            // ALTERAR EMAIL AO SAIR DO CAMPO ------------------------------------------------------------
            $(document).on("blur",".email_alterar",function(){    
                td=$(this);
                id_linha2= $(this).closest("tr").find("button").val();
                $.ajax({
                    url:"alterar_coluna.php",
                    type:"post",
                    data:{
                            coluna:'email',
                            valor:$("#email_alterar").val(),
                            id:id_linha2
                         },
                    success: function()
                    {
                        email = $("#email_alterar").val(),
                        td.html(email);
                        td.attr("class","email");
                    }
                });
               
            }); 

            // FILTRAR (PESQUISA) ----------------------------------------------------------------------------
            $("#filtrar").click(function(){
                $.ajax({
                    url:"paginacao.php",
                    type:"post",
                    data:
                    {
                        nome_filtro: $("input[name='nome_filtro']").val()
                    },
                    success: function(data)
                    {
                        $("#paginacao").html(data);
                        filtro = $("input[name='nome_filtro']").val();
                        paginacao(0);

                    }
                });
            });
            
        });
		</script>
    </head>
    <body>

        <form>
            
            <fieldset>
                <h1>Cadastro</h1>
                <br />
                Nome:<input type = "text" name = "nome" id = "n"/>
                <br /><br />
                Email:<input type = "text" name = "email" id = "e"/>
                <br /><br />
                Salario:<input type = "number" name = "salario" id = "salario" min="0" step="0.01"/>
                <br /><br />
                Cidade:<select id="es_cidade" name="cod_cidade">
                    <option></option>
    
                    <?php

                        while($linha=mysqli_fetch_assoc($resultado_cidade)){
                            $fk_cidade = $linha["id_cidade"];
                            $nome_cidade = $linha["nome_cidade"];
                            $uf = $linha["uf"];
                            echo "<option value='$fk_cidade'>$nome_cidade-$uf</option>";
                        }
                    ?>
                </select>
                <br /><br />

               
                Sexo:<input type="radio" name="sexo" value="m"> Masculino
                    <input type="radio" name="sexo" value="f"> Feminino
                <br /><br />
                <input type = "button" class = "btn_cadastra" value = "Cadastrar">

                <br />
                <br />
            </form>
                <div id = "status"></div>

                    

                <table border = "1">
                <form name = "filtro">
                    <input type="text" name="nome_filtro" placeholder="buscar pelo nome...">
                    <button type="button" id="filtrar">Filtrar</button>
                    <br />
                
                </form>
                <br />
                    <thead>
                        <tr>
                            <th>Nome</th> <th>Email</th> <th>Sexo</th> <th>Salario</th> <th>Cidade</th> <th>Estado</th> <th>Ação</th>
                        </tr>
                    </thead>

                
            
                    <tbody id = "tb">
                
                    </tbody>
                </table>
                <br />
                <div id="paginacao">
                    <?php
                        include("paginacao.php");
                    ?>
                </div>
            </fieldset>
    </body>
</html>