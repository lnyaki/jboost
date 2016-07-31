<div>
	<?php
		if(isset($_list)){
			$kanjiView = '';
			
			foreach($_list as $row)	{
				$kanjiView .= '<div class = "kanjiData">';
				$kanjiView .= 	'<div class = "kanjiElement">'.$row['kanji'].'</div>';
				$kanjiView .=   '<div class = "kanjiRightSide">';
				$kanjiView .=	'<div class = "yomiListDiv"> <span class="kanjiTitles">Kunyomi :</span>';
				
				//print_r($row);
				if(!empty($row['kunyomi'])){
					$kanjiView .= '<ul class = "yomiList">';
					//extract all the kunyomi
					foreach($row['kunyomi'] as $kunyomi){
						//$kanjiView .= '<li>'.$kunyomi[0].'【'.$kunyomi[1].'】</li>';
						$kanjiView .= '<li><span class="yomi">'.$kunyomi[0].'</span><span class="romaji">【'.$kunyomi[1].'】</span></li>';	
					}
					$kanjiView .=	'</ul>';
				}
				else{
					$kanjiView .= '<br/>None';
				}
				$kanjiView .= '</div>';
				
				$kanjiView .=	'<div class = "yomiListDiv"><span class="kanjiTitles">Onyomi :</span>';
				
				if(!empty($row['onyomi'])){
					$kanjiView .= '<ul class = "yomiList">';
					//extract all the onyomi
					foreach($row['onyomi'] as $onyomi){
						$kanjiView .= '<li><span class="yomi">'.$onyomi[0].'</span><span class="romaji">【'.$onyomi[1].'】</span></li>';	
					}
					$kanjiView .= '</ul>';
				}
				else{
					$kanjiView .= '<br/>None';
				}
				$kanjiView .= '</div>';
				$kanjiView .= '</div>'; //Closing the right side div
 				$kanjiView .= '<div class="strokesDiv"><span class="kanjiTitles">Strokes</span><span class="strokes">'.$row['strokes'].'</span></div>';
				
				
				$kanjiView .= '</div>'; //first div
			}
			//Display the kanji list
			echo $kanjiView;			
		}
	?>
</div>