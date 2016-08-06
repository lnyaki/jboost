<div>
	<?php
		if(isset($_list)){
			$kanaView = '';
			
			foreach($_list as $row)	{
				$kanaView .= "<div class='kanaMedium'>";
				//test if double kana. If so, use a smaller font.
				$kanaView .= "<div class='kanaElement'>".$row['kana1']."</div>";
				$kanaView .= "<div class='kanaRightSide'>";
				$kanaView .= "<div>".$row['romaji']."</div>";
				$kanaView .= "<div>".$row['kana2']."</div>";
				$kanaView .= "</div>";
				$kanaView .= "</div>";
			}
			//Display the kanji list
			echo $kanaView;			
		}
	?>
</div>