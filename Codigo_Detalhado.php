<?php
/* ---Versão do código detalhada---
* Projeto desenvolvido pelo bolsista: Marcos Vinicius Dos Reis Santos.			*
* A atividade foi implementada com o propósito de ser usada em um ambiente 		*
* de aprendizagem virtual (Moodle) para o ensino de danças a distância (EAD). 	*								
* O bolsista é vinculado a uma bolsa de complementação educacional oferecida	*
* pela SPE (Secretária de politica educacional) para estudantes de baixa renda.	*
* Orientador e coordenador do projeto: Cláudio Campanha Félix					*
* Referência Fundamental para o desenvolvimento do projeto: 					*
* Manual PHP <http://php.net/manual/pt_BR/>, acesso: 20-Setembro-2017  			*
* Concluído em: 30-Novembro-2017												*				
*/

//Chamar a funcao de controle para inicializar o programa
controle();

 function controle(){
	
	//posiçoes iniciais
	$posicaoXInicial = 200;
	$posicaoYInicial = 100;
	 //A seção acima é responsável por definir a posição inicial da primeira imagem. 
	
	//tamanhoQuadro de exibição
	$tamanhoQuadrox = 6000;
    	$tamanhoQuadroy = 5000;
	// A seção acima é responsável definir o tamanho total dos eixos X e Y do quadro de exibição.

	//Le o banco e retorna a String montada 
	$vetorEntes = leBancoDeDados(true);
	 //A seção acima é responsável por chamar a leitura do banco de dados, é passado como parâmetro “true” indicando que a tabela do banco de dados que deverá ser lida é a de conteúdo. Há um retorno para o vetor $vetorEntes, de forma que cada posição do vetor possui um ente, exemplo: $vetorEntes[0] = “Base 0”, $vetorEntes[1] = “Base 1”.

	$vetorRelacoes = leBancoDeDados(false);
	//A seção acima é responsável por chamar a leitura do banco de dados, é passado como parâmetro “false” indicando que a tabela do banco de dados que deverá ser lida é a de conteúdo_requisitos. Há um retorno para o vetor $vetorRelacoes, de forma que cada posição do vetor possui uma dependência, exemplo: $vetorRelacoes[0] = “Base 2>Base1”, $vetorRelacoes[1] = “Base 2 Aberta>Base 2”.

	//Fim le o banco
	
/*Declaração do painel para exibição das figuras (Intefarce)*/		
	// criar um painel para uma imagem 	
	$painel = imagecreate($tamanhoQuadrox, $tamanhoQuadroy);		
	//A seção acima é responsável pela criação do quadro de exibição, é passado como parâmetro as variáveis de definição de tamanho do quadro, já foi explicado acima. A função imagecreate() é um recurso da biblioteca GD. 
	
	// Aloca a cor branca para o fundo do painel
	$branca = imagecolorallocate($painel, 255, 255, 255);
	//A seção acima é responsável pela alocação da cor branca, é passado como parâmetro a variável $painel (É o quadro de exibição) e o código da cor branca. A função imagecolorallocate() é um recurso da biblioteca GD.
	
	// Aloca a cor preta para os entes
	$preta = imagecolorallocate($painel, 0, 0, 0);
	//A seção acima é responsável pela alocação da cor preta, é passado como parâmetro a variável $painel (É o quadro de exibição) e o código da cor branca. A função imagecolorallocate() é um recurso da biblioteca GD.
	//Fim Interface
	
	//montar String para desenho
	$stringMontadaVetor = montarString($vetorEntes, $vetorRelacoes);
	//A seção acima é responsável pela montagem e organização da string, é passado como parâmetro as variáveis $vetorEntes e $vetorRelacoes, Há um retorno para o vetor $stringMontadaVetor, de forma que cada posição do vetor possui uma hieraquia, exemplo: $stringMontadaVetor[0] = “elipse#X#Y#base0#elipse#X#Y#base1...”(São todos os itens independentes, ou sejam estão no topo da hieraquia), as próximas posições da variável será ocupada pelos elementos que dependem do anterior, logo, a segunda posição será ocupada pelos entes que dependem da primeira posição, assim sucessivamente.

	//fim montar string
	
	//processar os desenhos dos contornos das figuras 
	$posicoes = processamentoDesenho($stringMontadaVetor, $painel, $branca, $preta, true, 	$posicaoXInicial, $posicaoYInicial, $tamanhoQuadrox, $tamanhoQuadroy);
//A seção acima é responsável por chamar a função para processar o desenho, ou seja, definir quais serão as ordens e níveis de cada figura, é passado como parâmetro as variáveis:  $stringMontadaVetor (Essa variavél é responsável por conter as ordens e os níveis de cada figura), $painel (Essa variavél é o painel que foi definido pelo recurso da biblioteca GD do PHP), $branca, $preta (As variáveis $branca e $preta são recursos de cor da biblioteca), true (É uma variavél do tipo booleana, significa que será desenhado uma figura de cor preta solida), $posicaoXInicial, $posicaoYInicial, $tamanhoQuadrox, $tamanhoQuadroy (As últimas 4 variáveis são responsáveis pelo posicionamento da figura), Há um retorno para o vetor $posicoes, de forma que cada posição do vetor possui a localização de cada figura, exemplo: $posicoes[0] = “Base 0#localizaçãoX#localizaçãoY ”,$posicoes[1] = “Base 1#localizaçãoX#localizaçãoY”.
	//fim do processamento 
	
	//desenhar ligações
	processarRelacoes($vetorRelacoes, $posicoes, $painel, $preta);
	//A seção acima é responsável por chamar a função para desenhar as relações entre as figuras, de acordo com a tabela Conteudo_Requisitos,  é passado como parâmetro as variáveis: $vetorRelacoes (Vetor de relações), $posicoes (Posição de cada figura), $painel (Painel de exibição), $preta (Cor preta).
	//fim desenhar ligações
	
	//processar os desenhos dos fundos das figuras 
	processamentoDesenho($stringMontadaVetor, $painel, $branca, $preta, false, $posicaoXInicial, $posicaoYInicial, $tamanhoQuadrox, $tamanhoQuadroy);
	//A seção acima é responsável por chamar a função para processar o desenho, ou seja, definir quais serão as ordens e níveis de cada figura, é passado como parâmetro as variáveis:  $stringMontadaVetor (Essa variavél é responsável por conter as ordens e os níveis de cada figura), $painel (Essa variavél é o painel que foi definido pelo recurso da biblioteca GD do PHP), $branca, $preta (As variáveis $branca e $preta são recursos de cor da biblioteca), true (É uma variavél do tipo booleana, significa que será desenhado o contorno de cada figura da cor brenca), $posicaoXInicial, $posicaoYInicial, $tamanhoQuadrox, $tamanhoQuadroy (As últimas 4 variáveis são responsáveis pelo posicionamento da figura).
	//fim do processamento
	
	
	// Desenhar a imagem
	header('Content-Type: image/png');
//A seção acima é responsável por enviar o cabeçalho e a imagem para o navegador
	imagepng($painel);
//A seção acima é responsável por emitir uma imagem PNG para o navegador ou arquivo.
	imagedestroy($painel);
	//A seção acima é responsável por destruir uma imagem após a mesma ser transferida para o navegador, assim liberando espaço da memória.

	

}


//A função leBancoDeDados é usada para buscar as informações a cerca dos entes e suas relações  através da tabela do banco de dados. É recebido como parâmetro uma variável do tipo booleana.

function leBancoDeDados($boleana){	
	//Estabelecer comunicação com o banco de dados mysql
	$conexao = mysqli_connect("localhost", "root", "", "comitiva_system");
	//A seção acima é responsável por estabelecer a conexão ao banco de dados, é passado como parâmetro: localhost (É o endereço de acesso ao banco de dados mysql), root (É o usuário de acesso), "" (O Espaço vazio é destinado a inserção da senha, no meu exemplo é vazia), comitiva_system (É o nome do banco)

	if($boleana){
		$c=0;
		$dadosEntes = mysqli_query($conexao, "SELECT * FROM conteudo");
		//A seção acima é responsável por estabelecer a conexão da tabela Conteúdo do banco.
	
		mysqli_fetch_array($dadosEntes);
		//A seção acima é responsável por lê a tabela Conteúdo e salvar a primeira linha na variável $dadosEntes. OBS.: A primeira linha é desprezada porque a primeira linha da tabela Conteúdo é null.
	
		while ($entesbd = mysqli_fetch_array($dadosEntes)){	
			$entes[$c++] = $entesbd[0];
		}
		//A seção acima é responsável por lê toda a tabela Conteúdo e salvar os entes no vetor $entes. 
		
		mysqli_close($conexao);
		//A seção acima é responsável por encerrar a conexão com o banco. 
		return $entes;	
		//A seção acima é responsável por retornar o vetor com todos os entes, exemplo: $entes[0]=”Base0”,$entes[1]=”Base1”, $entes[0]=”Base0”, assim por diante.
	
	}else{
		$dadosRelacoes = mysqli_query($conexao, "SELECT * FROM conteudo_requisitos");
		//A seção acima é responsável por estabelecer a conexão da tabela Conteúdo_Requisitos do banco.
		$relacoes = "";
		//A seção acima é responsável por tirá o lixo de memória da variável $relacoes
		while ($relacoesbd = mysqli_fetch_array($dadosRelacoes)){
			if(strcmp($relacoes, "")!=0){
				$relacoes .= "#";
			}	
			$relacoes .= $relacoesbd[0];
			$relacoes .= ">";
			$relacoes .= $relacoesbd[2];
		}
		//A seção acima é responsável por lê toda a tabela Conteúdo_Requisitos e salvar os requisitos na variável $relacoes, exemplo: $relacoes=”Base2>Base1#Base2Aberta>Base2 ….”, o simbolo # significa separação de relações. 

		mysqli_close($conexao);
		//A seção acima é responsável por encerrar a conexão com o banco. 

		$vetorRelacoes = explode("#",$relacoes);
		//A seção acima é responsável por separa a string criada na variável $relacoes, de modo que cada posição do vetor seja uma relação idependente. 
		return $vetorRelacoes;
		//A seção acima é responsável por retornar o vetor com todas as relacoes, exemplo: $vetorRelacoes]=”Base2>Base1”, $vetorRelacoes[1]=”Base2 aberta>Base2”, assim por diante.
	}	
}

//A função montarString é responsável por definir e organizar os níveis de cada figura de acordo com sua relação.

function montarString($vetorEntes, $vetorRelacoes){
	//processamento 1
	$itemIdependentes = processamento1($vetorEntes, $vetorRelacoes);
	//A seção acima é responsável por definir quais serão os entes que ocuparam o topo da hierarquia, com outras palavras, os entes que não estão relacionados a outros entes.
	//fim processamento 1
	$contador = 0;
	//A seção acima é responsável por limpa a variável
	$stringMontadaVetor[$contador++] = montarStringMontadora($itemIdependentes);
	//A seção acima é responsável por chamar uma função para montar uma string com os dados, há um retorno de uma string que é salvar na posição do vetor.  
	//processamento 2
	$itemNaoIdependentes = processamento2($vetorRelacoes, $itemIdependentes);
	//A seção acima é responsável por definir quais serão os entes que dependem diretamente dos itens não dependentes, logo ocupam o segundo lugar da hierarquia.
	//fim processamento 2
	
	$stringMontadaVetor[$contador++] = montarStringMontadora($itemNaoIdependentes);
	//A seção acima é responsável por chamar uma função para montar uma string com os dados, há um retorno de uma string que é salvar na posição do vetor que é definido pelo contador.
	$marcador = true;
//A seção acima é responsável por fazer uma condição para o laço while	
	while($marcador){
		//processamento 2
		$itemNaoIdependentes = processamento2($vetorRelacoes, $itemNaoIdependentes);
		//fim processamento 2
		
		if($itemNaoIdependentes!=null){
			$stringMontadaVetor[$contador++] = montarStringMontadora($itemNaoIdependentes);
		}else{
			break;
		}	
	}
	//A seção do while acima é responsável por definir quais serão os próximos itens dependente a serem processados, também há dentro do if uma função para montar uma string com os dados, há um retorno de uma string que é salvar na posição do vetor que é definido pelo contador.  	
	return $stringMontadaVetor;
	//A seção acima é responsável por retornar um vetor, cada posição do vetor há um hierarquia.
}

//A função montarStringMontadora é responsável por formatar um vetor de item recebido como parâmetro. Assim há um retorno de uma string montada, exemplo: $stringMontadora = ”elipse#X#Y#Base1#elipse#X#Y#Base0#elipse#X#Y#Rastap#...”.

function montarStringMontadora($item){
	$i=0;
	$stringMontadora = "";
	$tamanhoVetor = sizeof($item);
	while($i < $tamanhoVetor){
		if($stringMontadora!=""){
			$stringMontadora .= "#";
		}	
		$stringMontadora .= "elipse";
		$stringMontadora .= "#";
		$stringMontadora .= 10 * strlen($item[$i]);
		$stringMontadora .= "#";
		$stringMontadora .= 8 * strlen($item[$i]);
		$stringMontadora .= "#";
		$stringMontadora .= $item[$i];
		$i +=1;
	}
	return $stringMontadora;
}

//A função processamento1 é responsável por percorrer os vetores $vetorEntes e $vetorRelacoes para encontrar os entes que não possuem dependentes, ou seja, os elementos do topo da hierarquia, após encontrar todos os elementos não dependentes e salvar na variável $primeiros, haverá o retorno da variável.

function processamento1($vetorEntes, $vetorRelacoes){
	$tamanhoVetorEntes = sizeof($vetorEntes);
	$tamanhoVetorRelacoes = sizeof($vetorRelacoes);
	$c=0;
	$tamanhoVetorEntes = sizeof($vetorEntes);
	for($i=0; $i<$tamanhoVetorEntes; $i++){
		$marcador = true;
		
		for($j=0; $j<$tamanhoVetorRelacoes; $j++){
			$figuraEntes = explode(">",$vetorRelacoes[$j]);
			//exemplo: figuraEntes[0] = b2 | figuraEntes[1] = b1, então logo: b2>b1
			if(strcmp($figuraEntes[0], $vetorEntes[$i])==0){
				$marcador = false;
			}	
		}
		
		if($marcador==true){
			$primeiros[$c++] =  $vetorEntes[$i];
		}	
	}	
	return $primeiros;
}

//A função processamento2 é responsável por percorrer o vetor $vetorRelacoes para encontrar os entes que possuem relações com $relacionador (É recebido como parâmetro), exemplo: o vetor $relacionador recebe base1, e o vetorRelacoes recebe uma cópia de todas as relações, de forma que no laço for será usado para buscar todas as entidades que dependem da base1. Todas as entidades que dependem de base1 ocupará uma posição no vetor nível que será retornado.

function processamento2 ($vetorRelacoes, $relacionador){
	$tamanhoVetorRelacionador = sizeof($relacionador);	
	$tamanhoVetorRelacoes = sizeof($vetorRelacoes);
	$c=0;
	//$c=0;
	$nivel = array();
	//$nivel = null;
	$b=0;
	for($i=0; $i<$tamanhoVetorRelacionador-1; $i++){
		$marcador = false;
		for($j=0; $j<$tamanhoVetorRelacoes-1; $j++){
			$figuraEntes = explode(">",$vetorRelacoes[$j]);
			
			//Testando defeito

			//echo $figuraEntes[0];
			//Testando defeito

			//if((strcmp($figuraEntes[1], $relacionador[$i]) == 0) && (strcmp($nivel[$c], $figuraEntes[0]) != 0)){
			if((strcmp($figuraEntes[1], $relacionador[$i]) == 0) ){
				$nivel[$c] =  $figuraEntes[0];	
				$c+=1;
			}	
		}		
	}		

	//A funcao empty verifica se o array esta vazio, se tiver retorna 1 caso contrario retorna 0.
	if(empty($nivel)) return null;
	
	return $nivel;
}	

//A função desenharFigura é responsável por desenhar uma figura que pode ser retângulo, elipse ou losango. O tipo da figura, as medidas, suas posições, o nome, e a cor são recebidos como parâmetro. Também é recebido como parâmetro uma variável do tipo booleana, a variável é usada para definir se a figura a ser desenhada será o contorno ou senão será desenhado o fundo branco e em seguida o nome do ente.

function desenharFigura($figura, $comprimento, $largura, $painel, $black, $white, $texto, $posicaoEixox, $posicaoEixoy, $boleana){
	//Se boleana verdadeira desenhar o contono preto, se não desenha o fundo branco
	// Desenhar o retangulo
	if(strcmp($figura, "retangulo")==0){
		if($boleana){
			
			imagerectangle($painel, $posicaoEixox, $posicaoEixoy, $comprimento+$posicaoEixox, $largura+$posicaoEixoy, $black);
			$posicaoXretorno = $posicaoEixox+($comprimento)/2;
			$posicaoYretorno = $posicaoEixoy+($largura)/2;
			return "$posicaoXretorno#$posicaoYretorno#$texto";
		}else{
			imagefilledrectangle($painel, $posicaoEixox+1, $posicaoEixoy+1, $comprimento+$posicaoEixox-1, $largura+$posicaoEixoy-1, $white);
			imagestring($painel, 5, ($posicaoEixox + ($comprimento/2) - strlen($texto)*4.5), ($posicaoEixoy + $largura/2.5), $texto, $black);
		}	
	}
	else{
		if(strcmp($figura, "elipse")==0){
			if($boleana){
				imageellipse($painel, $posicaoEixox, $posicaoEixoy, $comprimento, $largura, $black);
				return "$posicaoEixox#$posicaoEixoy#$texto";
			}else{
				imagefilledellipse($painel, $posicaoEixox, $posicaoEixoy, $comprimento-1, $largura-1, $white);
				imagestring($painel, 5, ($posicaoEixox - strlen($texto)*4.5), $posicaoEixoy-10, $texto, $black);
			}	
		}
		else{
			if(strcmp($figura, "losango")==0){
				if($boleana){
					//Constante de posicionamento do losango
					$posicaox=0;
					$posicaoy=0;
					
					//Diagonal principal
					$variavel1 = $largura;
					$variavel2 = (2*$variavel1);

					//Diagonal principal
					$variavel3 = $comprimento/2;
					$variavel4 = ($variavel3*2);
					
					//Selecionar o losango
					imagepolygon($painel, array(
							$posicaoEixox+$variavel3, $posicaoy+$posicaoEixoy,
							$posicaoEixox+$posicaox, $variavel1+$posicaoEixoy,
							$posicaoEixox+$variavel3, $variavel2+$posicaoEixoy,
							$posicaoEixox+$variavel4, $variavel1+$posicaoEixoy,
							
					),
					4,
					$black);
					$posicaoXretorno = $posicaoEixox+$posicaox + $comprimento/2;
					$posicaoYretorno = $posicaoy+$posicaoEixoy + $largura;
					return "$posicaoXretorno#$posicaoYretorno#$texto";
				}else{
					//Constante de posicionamento do losango
					$posicaox=0;
					$posicaoy=0;
					
					//Diagonal principal
					$variavel1 = $largura;
					$variavel2 = (2*$variavel1);

					//Diagonal principal
					$variavel3 = $comprimento/2;
					$variavel4 = ($variavel3*2);
					
					//Selecionar o losango
					imagefilledpolygon($painel, array(
							$posicaoEixox+$variavel3, $posicaoy+$posicaoEixoy+2,
							$posicaoEixox+$posicaox+1, $variavel1+$posicaoEixoy,
							$posicaoEixox+$variavel3, $variavel2+$posicaoEixoy-2,
							$posicaoEixox+$variavel4-1, $variavel1+$posicaoEixoy,
							
					),
					4,
					$white);
					imagestring($painel, 5, (($posicaoEixox+$posicaox) + (($posicaoEixox+$variavel4)-($posicaoEixox+$variavel3)) - strlen($texto)*4), $variavel1+$posicaoEixoy -5, $texto, $black);
				}	
			}
			else{
				echo "Erro ao selecionar a imagem";
				return "false";
			}
		}			
	}
		
}

//A função responsável por interligar os entes é a função processar relações, recebe como parâmetro os vetores $vetorRelacoes, $posicoes, também o painel e a cor branca. Essa função também chama as funções para desenhar a linha de ligação e a certa.

function processarRelacoes($vetorRelacoes, $posicoes, $painel, $black){	
		//Processar as relações
	
	//Conta a quantidade de relações
	$countRelacoes = count($vetorRelacoes);

				//Processar as relacoes entre os entes
	//Contadores usados para controlar o for
	$contador2=0;
	$contador=0;
	
	for($i=1; $i<$countRelacoes-1; $i++){
		$contador=0;
		$figuraEntes = explode(">",$vetorRelacoes[$i]);
		$figuraPosicoes = explode("#", $posicoes[$contador++]);

		while(strcmp($figuraEntes[0], $figuraPosicoes[2])!=0){
			$figuraPosicoes = explode("#", $posicoes[$contador++]);
		}
		//Salvar as posições x e y da primeira figura
		$posicaoEixoFigura1x = $figuraPosicoes[0];
		$posicaoEixoFigura1y = $figuraPosicoes[1];
		$contador=0;
		$figuraPosicoes = explode("#", $posicoes[$contador]);
		
		while(strcmp($figuraEntes[1], $figuraPosicoes[2])!=0){
			$figuraPosicoes = explode("#", $posicoes[$contador++]);
		}
		//Salvar as posições x e y da segunda figura
		$posicaoEixoFigura2x = $figuraPosicoes[0];
		$posicaoEixoFigura2y = $figuraPosicoes[1];
		
		//Desenhar as relações passando como parametro as posições das duas figuras
		desenharRelacao( $posicaoEixoFigura1x, $posicaoEixoFigura1y, $posicaoEixoFigura2x, $posicaoEixoFigura2y, $painel, $black);	
		desenharSeta($posicaoEixoFigura1x, $posicaoEixoFigura1y, $posicaoEixoFigura2x, $posicaoEixoFigura2y, $painel, $black);
	}
}
function desenharRelacao($posicaoEixoFigura1x, $posicaoEixoFigura1y, $posicaoEixoFigura2x, $posicaoEixoFigura2y, $painel, $black){
	imagepolygon($painel, array(
			$posicaoEixoFigura1x, $posicaoEixoFigura1y,
			$posicaoEixoFigura2x, $posicaoEixoFigura2y,
			$posicaoEixoFigura2x, $posicaoEixoFigura2y,
			//0,0,
	),
	3,
	$black);			
}

function desenharSeta($posicaoEixoFigura1x, $posicaoEixoFigura1y, $posicaoEixoFigura2x, $posicaoEixoFigura2y, $painel, $black){
	
	//Ponto central da reta
	$ponto1x =(($posicaoEixoFigura2x +  $posicaoEixoFigura1x)/2) ;
	$ponto1y = (($posicaoEixoFigura2y +  $posicaoEixoFigura1y)/2);
	
	if($posicaoEixoFigura2x==$posicaoEixoFigura1x){		
		//ponto 2
		$ponto2x = $ponto1x - 6;
		$ponto2y = $ponto1y + 16;
		
		//ponto 3
		$ponto3x = $ponto1x + 6;
		$ponto3y = $ponto1y + 16;
	}
	else {
		if($posicaoEixoFigura2x>$posicaoEixoFigura1x){
			//Ponto 2
			$ponto2x = (($posicaoEixoFigura2x +  $posicaoEixoFigura1x)/2)-15;
			$ponto2y = (($posicaoEixoFigura2y +  $posicaoEixoFigura1y)/2)+4;
	
			//Ponto 3
			$ponto3x = (($posicaoEixoFigura2x +  $posicaoEixoFigura1x)/2)-10;
			$ponto3y = (($posicaoEixoFigura2y +  $posicaoEixoFigura1y)/2)+16;
		}
		else{
			if($posicaoEixoFigura2x<$posicaoEixoFigura1x){
				//Ponto 2
				$ponto2x = (($posicaoEixoFigura2x +  $posicaoEixoFigura1x)/2)+15;
				$ponto2y = (($posicaoEixoFigura2y +  $posicaoEixoFigura1y)/2)-4;
				
				//Ponto 3
				$ponto3x = (($posicaoEixoFigura2x +  $posicaoEixoFigura1x)/2)+10;
				$ponto3y = (($posicaoEixoFigura2y +  $posicaoEixoFigura1y)/2)+16;
			}
			else{
				return -1;
			}
		}
	}
	
	
	imagefilledpolygon($painel, array(
			$ponto1x, $ponto1y,
			$ponto2x, $ponto2y,
			$ponto3x, $ponto3y,
	),
	3,
	$black);	
}


function processamentoDesenho($stringMontadaVetor, $painel, $branca, $preta, $boleana, $posicaoXInicial, $posicaoYInicial, $tamanhoQuadrox, $tamanhoQuadroy){
	$tamanhoVetor = sizeof($stringMontadaVetor);
	$salto = ($tamanhoQuadrox - $posicaoXInicial)/($tamanhoVetor+1);
	$posicaoEixox = $salto;
	$posicaoEixoy = $posicaoYInicial;
	$contador = 0;
	
	for($i=0; $i < $tamanhoVetor; $i++){
		$dados = explode("#", $stringMontadaVetor[$i]);
		$tamanhoVetor1 = count($dados);
		
		$j=0;
		$maior = 0;
		
		while($j<$tamanhoVetor1){
			$figura = $dados[$j];
			$j+=1;
			$comprimento = $dados[$j];
			$j+=1;
			$largura = $dados[$j];
			$j+=1;
			$texto = $dados[$j];
			$j+=1;
			$posicao[$contador++] = desenharFigura($figura, $comprimento, $largura, $painel, $preta, $branca, $texto, $posicaoEixox, $posicaoEixoy, $boleana);
			$posicaoEixox += $salto;
			if($largura > $maior){
				 $maior = $largura;
			}
		}
		$posicaoEixox = $salto;
		$posicaoEixoy += 400;
		$posicaoEixoy += $maior; 
	}
	return $posicao;
}
?>