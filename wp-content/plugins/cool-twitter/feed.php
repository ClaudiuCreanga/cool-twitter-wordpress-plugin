<div class="cool-twitter-wrapper">
	<?php
		
		//convert twitter time
		function time_ago($date,$granularity=2) {
		    $date = strtotime($date);
		    $difference = time() - $date;
		    $periods = array('decade' => 315360000,
		        'year' => 31536000,
		        'month' => 2628000,
		        'week' => 604800, 
		        'day' => 86400,
		        'hour' => 3600,
		        'minute' => 60,
		        'second' => 1);
		
		    foreach ($periods as $key => $value) {
		        if ($difference >= $value) {
		            $time = floor($difference/$value);
		            $difference %= $value;
		            $retval .= ($retval ? ' ' : '').$time.' ';
		            $retval .= (($time > 1) ? $key.'s' : $key);
		            $granularity--;
		        }
		        if ($granularity == '0') { break; }
		    }
		    return ' posted '.$retval.' ago';      
		}

		
	    function buildBaseString($baseURI, $method, $params) {
	        $r = array();
	        ksort($params);
	        foreach($params as $key=>$value){
	            $r[] = "$key=" . rawurlencode($value);
	        }
	        return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
	    }
	
	    function buildAuthorizationHeader($oauth) {
	        $r = 'Authorization: OAuth ';
	        $values = array();
	        foreach($oauth as $key=>$value)
	            $values[] = "$key=\"" . rawurlencode($value) . "\"";
	        $r .= implode(', ', $values);
	        return $r;
	    }
	
	    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
	
	    $oauth_access_token = "2955093587-4IXwIIzlgm4AEH9BnFoS57Zt4wbhzFPly7KpIUc";
	    $oauth_access_token_secret = "gVbmfvxthPozpR9abRI5VBBl2gBz8CC2dBwgFhXi9O60k";
	    $consumer_key = "AwlfNCOexbA4dyPrUuEpln82a";
	    $consumer_secret = "mjuk9jWFpUohVkjr1bLYyKb0AFoNTvCtr6zPWutvepBGcXCbTi";
	
	    $oauth = array( 
					'screen_name' => 'Maria_Gioga',
					'count' => 50,
					'oauth_consumer_key' => $consumer_key,
                    'oauth_nonce' => time(),
                    'oauth_signature_method' => 'HMAC-SHA1',
                    'oauth_token' => $oauth_access_token,
                    'oauth_timestamp' => time(),
                    'oauth_version' => '1.0');
	
	    $base_info = buildBaseString($url, 'GET', $oauth);
	    $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
	    $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
	    $oauth['oauth_signature'] = $oauth_signature;
	
	    // Make requests
	    $header = array(buildAuthorizationHeader($oauth), 'Expect:');
	    $options = array( CURLOPT_HTTPHEADER => $header,
	                      //CURLOPT_POSTFIELDS => $postfields,
	                      CURLOPT_HEADER => false,
	                      CURLOPT_URL => $url.'?screen_name=Maria_Gioga&count=50',
	                      CURLOPT_RETURNTRANSFER => true,
	                      CURLOPT_SSL_VERIFYPEER => false);
	
	    $feed = curl_init();
	    curl_setopt_array($feed, $options);
	    $json = curl_exec($feed);
	    curl_close($feed);
	    $twitter_data = json_decode($json);
	    
	    ?>
	    
    	<ul class="tweets small-12 large-8 columns">
	    	
	    <?php $popular_hashtags = array() ?>
	    
	    <?php foreach($twitter_data as $item): ?>
	    
	    	<li class="tweet-item clearfix">
	    					    		
					<?php if(!isset($item->retweeted_status)): ?>
						<img alt="profile image" class="profile_image" src="<?php echo $item->user->profile_image_url ?>" />
					<?php else: ?>
						<img alt="profile image" class="profile_image" src="<?php echo $item->retweeted_status->user->profile_image_url ?>" />
					<?php endif ?>
					
		    		<?php if(!isset($item->retweeted_status)): ?>
						<p class="date">Maria Gioga tweeted on <?php echo date('jS F Y',strtotime($item->created_at))?> (<?php echo time_ago($item->created_at); ?>)</p>
					<?php else: ?>
						<p class="date"><img src="http://maria.dev/wp-content/themes/maria/images/icons/retweet.svg" class="image-retweeted" />Maria Gioga retweeted on<?php echo date('jS F Y',strtotime($item->created_at))?> (<?php echo time_ago($item->created_at); ?>)</p>
					<?php endif ?>		    
	    		
					<?php if(!isset($item->retweeted_status)): ?>
						<p class="text"><?php echo $item->text ?></p>
					<?php else: ?>
						<p class="text"><?php echo $item->retweeted_status->text ?></p>
					<?php endif ?>

					<p class="interact">
						<span class="retwitter">
							<?php 
    							if(!isset($item->retweeted_status)){
	    							echo $item->retweet_count."<img src='http://maria.dev/wp-content/themes/maria/images/icons/retweet.svg' class='image-retweeted' />"; 
    							}
    							else{
	    							echo $item->retweeted_status->retweet_count."<img src='http://maria.dev/wp-content/themes/maria/images/icons/retweet.svg' class='image-retweeted' />"; 
    							}
    						?>
						</span>
						<span class="favorites">
							<?php 
    							if(!isset($item->retweeted_status)){
	    							echo $item->favorite_count."<img src='http://maria.dev/wp-content/themes/maria/images/icons/heart.svg' class='image-retweeted' />"; 
    							}
    							else{
	    							echo $item->retweeted_status->favorite_count."<img src='http://maria.dev/wp-content/themes/maria/images/icons/heart.svg' class='image-retweeted' />"; 
    							}
    						?>
						</span>
					</p>
					<?php if($item->entities->hashtags):  ?>
					<p class="hashtags">Hashtags: 
						
						<?php foreach($item->entities->hashtags as $hashtag): ?>
						
							<a class="hashtag" href="https://twitter.com/hashtag/<?php echo $hashtag->text ?>?src=hash">#<?php echo $hashtag->text ?></a>
						
						<?php $popular_hashtags[] =  $hashtag->text; ?>
						<?php endforeach ?>

					</p>
					<?php endif ?>
					
					<?php if($item->entities->urls): ?>
						
							<p>Link: <a class="links" href="<?php echo $item->entities->urls[0]->expanded_url ?>"><?php echo $item->entities->urls[0]->expanded_url ?></a></p>
						
					<?php endif ?>
	    	</li>
	    	
		<?php endforeach ?> 

		
	</ul>
	
	<div class="hide-for-medium-down large-4 columns cloud">
    	<p>My most popular hashtags: </p>
    	<ul class="tag-cloud">
	    	
			<?php 
			
				$hashtag_weight = array_count_values($popular_hashtags); 
				arsort($hashtag_weight);
				$top10hash = array_slice($hashtag_weight, 0, 10);

				
			?> 
			
			<?php foreach($top10hash as $key=>$value):?>
			
				<li class="tag-item"><a href="https://twitter.com/hashtag/<?php echo $key ?>?src=hash">#<?php echo $key ?></a></li>
			
			<?php endforeach ?>
	    	
    	</ul>
	</div>
</div>
 