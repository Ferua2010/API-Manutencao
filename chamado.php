<?php

header("Content-Type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

if($metodo == "POST"){

    $json = file_get_contents("php://input");

    $dados = json_decode($json,true);

    if($dados["prioridade"] == "baixa" || $dados["prioridade"] == "media" || $dados["prioridade"] == "alta"){

        if($dados["status"] == "aberto" || $dados["status"] == "em andamento" || $dados["status"] == "concluido"){
            $sql = "INSERT INTO chamados (nome,setor,descricao,prioridade,status) VALUES (?,?,?,?,?)";

            $comando = $pdo -> prepare($sql);

            $comando -> execute([
                $dados["nome"],
                $dados["setor"],
                $dados["descricao"],
                $dados["prioridade"],
                $dados["status"]
            ]);

            echo json_encode(["Mensagem"=>"Chamado realizado com sucesso!"]);
    } else{ 
         echo json_encode(["Mensagem"=>" O status deve ser aberto, em andamento ou concluido"]);

    }
        } else{
            echo json_encode(["Mensagem"=>"Você deve selecionar entre prioridade baixa, media ou alta "]);

    }    
};


if($metodo == "GET"){

    $sql = "SELECT * FROM chamados ORDER BY id";

    $comando = $pdo -> query($sql);
    
    $produtos = $comando -> fetchALL(PDO::FETCH_ASSOC);

    echo json_encode($produtos);
};

if($metodo == "PUT"){
    $json = file_get_contents("php://input");

    $dados = json_decode($json,true);

    if($dados["prioridade"] == "baixa" || $dados["prioridade"] == "media" || $dados["prioridade"] == "alta"){

            if($dados["status"] == "aberto" || $dados["status"] == "em andamento" || $dados["status"] == "concluido"){
            
            $sql = "UPDATE chamados SET nome=?, setor=?, descricao=?, prioridade=?, status=? WHERE id=?";
            
            $comando = $pdo->prepare($sql);
            
            $comando->execute([
                $dados["nome"],
                $dados["setor"],
                $dados["descricao"],
                $dados["prioridade"],
                $dados["status"],
                $dados["id"]
            ]);

                echo json_encode(["Mensagem"=>"Chamado atualizado com sucesso!"]);
        } else{ 
            echo json_encode(["Mensagem"=>" O status deve ser aberto, em andamento ou concluido"]);

        }
            } else{
            echo json_encode(["Mensagem"=>"Você deve selecionar entre prioridade baixa, media ou alta "]);
        }
}

  

if($metodo == "DELETE"){
    $json = file_get_contents("php://input");

    $dados = json_decode($json,true);

    $sql = "DELETE FROM produtos WHERE id=? ";

   $comando = $pdo -> prepare($sql);
    
    $comando  -> execute([
        $dados["id"]
    ]);

    echo json_encode(["Mensagem"=>"Produto excluído com sucesso!"]);
}