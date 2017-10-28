<?php
/** 
 * Manage the social share buttons for socials
 * @package INSTANTFBLOGIN::plugins::content
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');
class plgContentInstantfbloginShare extends JPlugin {
	/**
	 * Default lang tags
	 * @var string
	 * @access private
	 */
	private $langTag = "en_US";
	
	/**
	 * Default lang starttag
	 * @var string
	 * @access private
	 */
	private $langStartTag = 'en';
	
	/**
	 * Component dispatch view
	 * @var string
	 * @access private
	 */
	private $componentView = null;
	
	/**
	 * Adapters mapping based on context and route helper
	 *
	 * @access private
	 * @var array
	 */
	private $adaptersMapping;
	
	/**
	 * Generate content
	 * @param   object      The article object.  Note $article->text is also available
	 * @param   object      The article params
	 * @param   boolean     Modules context
	 * @return  string      Returns html code or empty string.
	 */
	private function getContent(&$article, &$params, $moduleContext = false) {

		$doc = JFactory::getDocument();
		/* @var $doc JDocumentHtml */

		$doc->addStyleSheet(JURI::root() . "plugins/content/instantfbloginshare/style/style.css");

		$uriInstance = JURI::getInstance();
		
		if(!$moduleContext) {
			if(!class_exists('ContentHelperRoute')) {
				include_once JPATH_SITE . '/components/com_content/helpers/route.php';
			}
			if(!isset($article->slug)) {
				$url = JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid), false);
			} else {
				$url = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug), false);
			}
			$root = rtrim($uriInstance->getScheme() . '://' . $uriInstance->getHost(), '/');
			$url = $root . $url;
			$title = htmlentities($article->title, ENT_QUOTES, "UTF-8");
		} else {
			$url = JURI::current();
			$title = htmlentities($doc->title, ENT_QUOTES, "UTF-8");
		}

		$html = $this->getFacebookLike($this->params, $url, $title);
		$html .= $this->getFacebookShareMe($this->params, $url, $title);
		$html .= $this->getTwitter($this->params, $url, $title);
		$html .= $this->getGooglePlusOne($this->params, $url, $title);
		$html .= $this->getLinkedIn($this->params, $url, $title);
		$html .= $this->getPinterest($this->params, $url, $title);
		
		return '<div class="instantfbloginshare_container">' . $html . '<div class="instantfbloginshare_clearer"></div></div>';
	}

	private function getFacebookLike($params, $url, $title) {
		$html = "";
		if ($params->get("facebookLikeButton", true)) {
			// Require Facebook SDK if missing loading by login module and social buttons
			require_once JPATH_ROOT . '/components/com_instantfblogin/helpers/helper.php';
			InstantfbloginHelper::injectFacebookSDK(JFactory::getDocument(), true);
			
			$layout = $params->get("facebookLikeType", "button_count");
			if (strcmp("box_count", $layout) == 0) {
				$height = "80";
			} else {
				$height = "25";
			}
	
			$html = '<div class="instantfbloginshare-share-fbl ' . $layout . '">';
			$html .= '
				<div class="fb-like"
					data-href="' . $url . '"
					data-layout="' . $layout . '"
                	data-width="' . $params->get("facebookLikeWidth", "450") . '"
					data-action="' . $params->get("facebookLikeAction", 'like') . '"
					data-show-faces="' . $params->get("facebookLikeShowfaces", 'true') . '"
					data-share="false">
				</div>';
			$html .= '</div>';
		}
	
		return $html;
	}
	
	private function getFacebookShareMe($params, $url, $title) {
		// Get the number of shares for this URL
		$sharesCounterCode = null;
		if ($params->get("facebookShareMeCounter", 0)) {
			$encodedUrl = rawurlencode($url);
			$sharesJsonData = file_get_contents("https://graph.facebook.com/?id=" . $encodedUrl);
			if($sharesJsonData) {
				$sharesJsonData = json_decode($sharesJsonData);
				if(isset($sharesJsonData->share)) {
					$sharesObject = $sharesJsonData->share;
					$numberOfShares = $sharesObject->share_count;
					$sharesCounterCode = '<div class="fbshare_container_counter">
											<div class="pluginCountButton pluginCountNum">
												<span>
													<span class="pluginCountTextConnected">' . $numberOfShares . '</span>
												</span>
											</div>
											<div class="pluginCountButtonNub">
												<s></s>
												<i></i>
											</div>
										 </div>';
				}
			}
		}
		
		$html = "";
		if ($params->get("facebookShareMeButton", true)) {
			$colorText = $params->get("facebookShareMeBadgeText", "#FFFFFF");
			$badgeColor = $params->get("facebookShareMeBadge", "#3B5998");
			$badgeLabel = $params->get("facebookShareMeBadgeLabel", "Share");
			$encodedUri = rawurlencode($url);
			$html = <<<JS
						<div id="fbshare_container" class="instantfbloginshare-share-fbsh">
    					<a style="text-decoration:none; border-radius: 2px; padding:2px 5px; font-size:14px; background-color:$badgeColor; color:$colorText !important;" onclick="window.open('http://www.facebook.com/sharer/sharer.php?u=$encodedUri','fbshare','width=480,height=100')" href="javascript:void(0)"><span style="text-decoration:none; font-weight:bold; font-size:14px;margin-right:4px;">f</span>$badgeLabel</a>
						$sharesCounterCode
						</div>
JS;
		}
		return $html;
	}
	
	private function getTwitter($params, $url, $title) {
		$twitterCounter = $params->get("twitterCounter", 'none');
		$twitterName = $params->get("twitterName", '');
		$twitterSize = null;
		if($params->get("twitterSize", 0)) {
			$twitterSize = 'data-size="large"';
		}
		
		$html = "";
		if($params->get("twitterButton", true)) {
			$html = <<<JS
						<div class="instantfbloginshare-share-tw">
						<a href="https://twitter.com/share" class="twitter-share-button" $twitterSize data-text="$title" data-count="$twitterCounter" data-via="$twitterName" data-url="$url" data-lang="{$this->langStartTag}"></a>
						</div>
						<script>
							var loadAsyncDeferredTwitter =  function() {
	            						var d = document;
	            						var s = 'script';
	            						var id = 'twitter-wjs';
					            		var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){
						        		js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}
					        		}
						
							if (window.addEventListener)
								window.addEventListener("load", loadAsyncDeferredTwitter, false);
							else if (window.attachEvent)
								window.attachEvent("onload", loadAsyncDeferredTwitter);
							else
								window.onload = loadAsyncDeferredTwitter;
						</script>
JS;
		}
		
		
		return $html;
	}

	private function getLinkedIn($params, $url, $title) {
		$language = "lang: " . $this->langTag;
		
		$html = "";
		if ($params->get("linkedInButton", true)) {
			$dataCounter = $params->get("linkedInType", 'right');
			$html = <<<JS
						<div class="instantfbloginshare-share-lin">
						<script type="text/javascript">
							var loadAsyncDeferredLinkedin =  function() {
								var po = document.createElement('script');
								po.type = 'text/javascript';
								po.async = true;
								po.src = 'https://platform.linkedin.com/in.js';
								po.innerHTML = '$language';
								var s = document.getElementsByTagName('script')[0];
								s.parentNode.insertBefore(po, s);
							};
		
							 if (window.addEventListener)
							  window.addEventListener("load", loadAsyncDeferredLinkedin, false);
							else if (window.attachEvent)
							  window.attachEvent("onload", loadAsyncDeferredLinkedin);
							else
							  window.onload = loadAsyncDeferredLinkedin;
						</script>
						<script type="in/share" data-url="$url" data-counter="$dataCounter"></script>
						</div>
JS;
		}
	
		return $html;
	}
	
	private function getGooglePlusOne($params, $url, $title) {
		$plusButton = null;
		$gShareButton = null;
		$type = 'size="' . $params->get("plusType", 'medium') . '"';
		$shareAnnotation = $params->get("shareAnnotation", 'bubble');
		$language = " {lang: '" . $this->langStartTag . "'}";

		if($params->get("plusButton", true)) {
			$plusButton = "<g:plusone annotation='$shareAnnotation' $type href='$url'></g:plusone>";
		}
		
		if($params->get("gshareButton", true)) {
			$gShareButton = "<g:plus annotation='$shareAnnotation' href='$url' action='share'></g:plus>";
		}
		
			$html = <<<JS
						<div class="instantfbloginshare-share-gone">
						<script type="text/javascript">
							 window.___gcfg = {
						        lang: '{$this->langStartTag}'
						      };
							var loadAsyncDeferredGooglePlus =  function() {
								var po = document.createElement('script'); 
								po.type = 'text/javascript'; 
								po.async = true;
								po.src = 'https://apis.google.com/js/plusone.js';
								po.innerHTML = $language;
								var s = document.getElementsByTagName('script')[0]; 
								s.parentNode.insertBefore(po, s);
							};
			
							 if (window.addEventListener)
							  window.addEventListener("load", loadAsyncDeferredGooglePlus, false);
							else if (window.attachEvent)
							  window.attachEvent("onload", loadAsyncDeferredGooglePlus);
							else
							  window.onload = loadAsyncDeferredGooglePlus;
						</script>
						$plusButton
						$gShareButton
						</div>
JS;
		
		
		return $html;
	}
	
	private function getPinterest($params, $url, $title) {
		$html = "";
		if($params->get("pinterestButton", true)) {
			$html = <<<JS
						<div class="instantfbloginshare-share-pinterest">
						<a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"  data-pin-color="red"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a>
						<script type="text/javascript">
							(function (w, d, load) {
							 var script, 
							 first = d.getElementsByTagName('SCRIPT')[0],  
							 n = load.length, 
							 i = 0,
							 go = function () {
							   for (i = 0; i < n; i = i + 1) {
							     script = d.createElement('SCRIPT');
							     script.type = 'text/javascript';
							     script.async = true;
							     script.src = load[i];
							     first.parentNode.insertBefore(script, first);
							   }
							 }
							 if (w.attachEvent) {
							   w.attachEvent('onload', go);
							 } else {
							   w.addEventListener('load', go, false);
							 }
							}(window, document, 
							 ['//assets.pinterest.com/js/pinit.js']
							));    
							</script>
						</div>
JS;
		}
	
			return $html;
	}
	
	/**
	 * Route save single article to the corresponding SEF link
	 *
	 * @access private
	 * @return string
	 */
	private function routeArticleToSefMenu($articleID, $catID, $language, $article) {
		// Include the multilanguage class
		include_once (JPATH_ROOT . '/administrator/components/com_instantfblogin/framework/language/multilang.php');

		// Try to route the article to a single article menu item view
		$helperRouteClass = $this->context ['class'];
		$classMethod = $this->context ['method'];
		
		$siteRouter = JRouterSite::getInstance ( 'site', array (
				'mode' => JROUTER_MODE_SEF
		) );
	
		// Route helper native by component, com_content, com_k2
		$articleHelperRoute = $helperRouteClass::$classMethod ( $articleID, $catID, $language );
	
		// Extract Itemid from the helper routed URL
		$foundItemid = preg_match ( '/Itemid=\d+/i', $articleHelperRoute, $result );
		
		// Joomla 3.6- legacy router
		if($foundItemid && isset ( $result [0] )) {
			$extractedItemid = $result [0];
			$articleMenuRouted = $siteRouter->build ( '?' . $extractedItemid )->toString ();
		}
		
		// Joomla 3.7+ new router
		if(!$foundItemid && version_compare ( JVERSION, '3.7', '>=' ) && stripos($articleHelperRoute, 'com_content')) {
			$articleMenuRouted = $siteRouter->build ($articleHelperRoute)->toString();
		}
	
		if ($articleMenuRouted) {
			// Get uri instance avoidng subdomains already included in the routing chunks
			$uriInstance = JUri::getInstance();
			$resourceLiveSite = rtrim($uriInstance->getScheme() . '://' . $uriInstance->getHost(), '/');
			if(!JFactory::getConfig()->get('sef_rewrite')) {
				$resourceLiveSite .= '/index.php';
			}

			// Check if multilanguage is enabled
			if (InstantfbloginLanguageMultilang::isEnabled ()) {
				$defaultLanguage = JComponentHelper::getParams('com_languages')->get('site');
				if ($language != '*') {
					// New language manager instance
					$languageManager = InstantfbloginLanguageMultilang::getInstance ( $language );
				} else {
					// Get the default language tag
					// New language manager instance
					$languageManager = InstantfbloginLanguageMultilang::getInstance ($defaultLanguage);
				}
	
				// Extract the language tag
				$selectedLanguage = $languageManager->getTag();
				$languageFilterPlugin = JPluginHelper::getPlugin('system', 'languagefilter');
				$languageFilterPluginParams = new JRegistry($languageFilterPlugin->params);
				if($defaultLanguage == $selectedLanguage && $languageFilterPluginParams->get('remove_default_prefix', 0)) {
					$articleMenuRouted = str_replace ( '/administrator', '', $articleMenuRouted );
				} else {
					$localeTag = $languageManager->getLocale ();
					$sefTag = $localeTag [4];
					$articleMenuRouted = str_replace ( '/administrator', '/' . $sefTag, $articleMenuRouted );
				}
			} else {
				$articleMenuRouted = str_replace ( '/administrator', '', $articleMenuRouted );
			}
			$articleMenuRouted = preg_match('/http/i', $articleMenuRouted) ? $articleMenuRouted : $resourceLiveSite . '/' . ltrim($articleMenuRouted, '/');
			return $articleMenuRouted;
		} else {
			// Check if routing is valid otherwise throw exception
			throw new RuntimeException ( 'No SEF link' );
		}
	}
	
	/**
	 * Add social buttons into the article
	 *
	 * Method is called by the view
	 *
	 * @param   string  The context of the content being passed to the plugin.
	 * @param   object  The content object.  Note $article->text is also available
	 * @param   object  The content params
	 * @param   int     The 'page' number
	 * @since   1.6
	 */
	public function onContentPrepare($context, &$article, &$params, $limitstart) {
		// Check if the plugin is enabled
		if(!$this->params->get('social_sharer_enabled', 0)) {
			return;
		}
		
		$app = JFactory::getApplication();
		/* @var $app JApplication */
	
		if ($app->isAdmin()) {
			return;
		}
		
		if(!$article instanceof stdClass || $context == 'com_content.categories') {
			return;
		}
	
		$doc = JFactory::getDocument();
		/* @var $doc JDocumentHtml */
		$docType = $doc->getType();
	
		// Check document type
		if (strcmp("html", $docType) != 0) {
			$article->text = str_replace('{instantfbloginshare}', '', $article->text);
			return;
		}
		// Output JS APP nel Document
		if($app->input->get('print')) {
			$article->text = str_replace('{instantfbloginshare}', '', $article->text);
			return;
		}
	
		$this->componentView = $app->input->get("view");
		$isValidContext = !!preg_match('/com_content/i', $context);
		$isModuleContext = !!preg_match('/mod_custom/i', $context);
		
		// Check if it's a mod_custom context and manage as page URL sharing
		if($isModuleContext) {
			// Get plugin contents
			$content = $this->getContent($article, $params, true);
			$article->text = str_replace('{instantfbloginshare}', $content, $article->text);
			return;
		}
		
		// Extract the first image from the article-entity/first article-entity text html for all extensions calling onContentPrepare
		if($article->text) {
			if($this->params->get('ogimage_detection', 0) && !$doc->getMetaData('og:image')) {
				$firstImageFound = preg_match('/(<img)([^>])*(src=["\']([^"\']+)["\'])([^>])*/i', $article->text, $matches);
				if($firstImageFound) {
					$firstImage = $matches[4];
					$firstImage = preg_match('/^http/i', $firstImage) ? $firstImage : JUri::root(false) . ltrim($firstImage, '/');
					$doc->setMetaData('og:image', $firstImage);
					$doc->addCustomTag("<meta property='og:image' content='" . $firstImage . "'/>");
					
					// Get image width/height and force the native meta propery tags for immediate share crawling
					$imagePath = JPATH_ROOT . '/' . ltrim($matches[4], '/');
					if(file_exists($imagePath)) {
						list($width, $height) = getimagesize($imagePath);
						$doc->addCustomTag("<meta property='og:image:width' content='" . $width . "'/>");
						$doc->addCustomTag("<meta property='og:image:height' content='" . $height . "'/>");
					}
					
					if($this->params->get('twitter_card_enable', 0)) {
						$doc->setMetaData('twitter:image', $firstImage);
					}
				}
			}
			if($this->params->get('ogtitle_detection', 0) && isset($article->title) && !$doc->getMetaData('og:title')) {
				$doc->setMetaData('og:title', $article->title, 'property');
				if($this->params->get('twitter_card_enable', 0)) {
					$doc->setMetaData('twitter:title', $article->title);
				}
			}
			if($this->params->get('ogdescription_detection', 0) && !$doc->getMetaData('og:description')) {
				$dots = JString::strlen($article->text) > 300 ? '...' : '';
				$description = JString::substr(strip_tags($article->text), 0, 300);
				$description = str_replace(PHP_EOL, '', $description);
				$description .= $dots;
				$doc->setMetaData('og:description', $description, 'property');
				if($this->params->get('twitter_card_enable', 0)) {
					$doc->setMetaData('twitter:description', $description);
				}
			}
			
			// Insert additional meta tags
			if($this->params->get('ogadditional_tags', 1)) {
				$doc->setMetaData('og:url', JUri::current(), 'property');
				$doc->setMetaData('og:site_name', JFactory::getConfig()->get('sitename'), 'property');
				$doc->setMetaData('og:locale', $this->langTag, 'property');
				$doc->setMetaData('og:type', 'article', 'property');
				if($this->params->get('appId', null)) {
					$doc->setMetaData('fb:app_id', $this->params->get('appId'));
				}
			}
			
			// Insert Twitter card meta tags
			if($this->params->get('twitter_card_enable', 0)) {
				$doc->setMetaData('twitter:card', $this->params->get('twitter_card_type', 'summary'));
				if($twitterSiteUsername = $this->params->get('twitter_card_site', '')) {
					$doc->setMetaData('twitter:site', $twitterSiteUsername);
				}
				if($twitterCreatorUsername = $this->params->get('twitter_card_creator', '')) {
					$doc->setMetaData('twitter:creator', $twitterCreatorUsername);
				}
			}
		}
			
		if (!$isValidContext || !isset($this->params)) {
			return;
		}
	
		$custom = $this->params->get('custom', 0);
		if ($custom) {
			$foundReplace = strstr($article->text, '{instantfbloginshare}');
		}
	
		/** Check for selected views, which will display the buttons. **/
		/** If there is a specific set and do not match, return an empty string.**/
		$showInArticles = $this->params->get('showInArticles', 1);
		$showInFrontpage = $this->params->get('showInFrontPage', 1);
	
		if (!$showInArticles && ($this->componentView == 'article')) {
			return "";
		}
		
		if (!$showInFrontpage && ($this->componentView == 'featured')) {
			return "";
		}
	
		// Check for category view
		$showInCategories = $this->params->get('showInCategories');
	
		if (!$showInCategories && ($this->componentView == 'category')) {
			return;
		}
	
		if (!isset($article) OR empty($article->id)) {
			return;
		}
	
		$excludeArticles = $this->params->get('excludeArticles', array());
		if (!empty($excludeArticles)) {
			$excludeArticles = explode(',', $excludeArticles);
			JArrayHelper::toInteger($excludeArticles);
		}
	
		// Exluded categories
		$excludedCats = $this->params->get('excludeCats', array());
		if (!empty($excludedCats)) {
			$excludedCats = explode(',', $excludedCats);
			JArrayHelper::toInteger($excludedCats);
		}
	
		// Included Articles
		$includedArticles = $this->params->get('includeArticles', array());
		if (!empty($includedArticles)) {
			$includedArticles = explode(',', $includedArticles);
			JArrayHelper::toInteger($includedArticles);
		}
	
		if (!in_array($article->id, $includedArticles)) {
			// Check exluded places
			if (in_array($article->id, $excludeArticles) OR in_array($article->catid, $excludedCats)) {
				return "";
			}
		}
	
		// Get plugin contents
		$content = $this->getContent($article, $params);
	
		if ($custom) {
			if ($foundReplace) {
				$article->text = str_replace('{instantfbloginshare}', $content, $article->text);
			}
		} else {
			$position = $this->params->get('position');
	
			switch ($position) {
				case 0:
					$article->text = $content . $article->text . $content;
					break;
				case 1:
					$article->text = $content . $article->text;
					break;
				case 2:
					$article->text = $article->text . $content;
					break;
				default:
					break;
			}
		}
		return;
	}
	
	/**
	 * Method to be called everytime an article in backend is saved,
	 * it's responsible to check and find if the SEF link of the article has been
	 * added to the Pingomatic table, and if found submit the ping form through CURL http adapter
	 *
	 * @param string $context
	 *        	The context of the content passed to the plugin (added in 1.6)
	 * @param object $article
	 *        	A JTableContent object
	 * @param boolean $isNew
	 *        	If the content is just about to be created
	 *
	 * @return boolean true if function not enabled, is in front-end or is new. Else true or
	 *         false depending on success of save function.
	 */
	public function onContentAfterSave($context, $article, $isNew) {
		$app = JFactory::getApplication();
		$task = $app->input->get('task');
		
		// Avoid operations if the feature is not enabled
		if ((! $this->params->get ( 'facebookAutoPosting', 0 )
		  && ! $this->params->get ( 'gplusAutoPosting', 0 )
		  && ! $this->params->get ( 'twitterAutoPosting', 0 )) || $task !== 'apply' ) {
			return;
		}
		
		// Avoid operations if plugin is executed in frontend
		if (!$app->isAdmin() || !$isNew) {
			return;
		}
		
		$this->adaptersMapping = array (
				'com_content.article' => array (
						'file' => JPATH_ROOT . '/components/com_content/helpers/route.php',
						'class' => 'ContentHelperRoute',
						'method' => 'getArticleRoute'
				),
				'com_k2.item' => array (
						'file' => JPATH_ROOT . '/components/com_k2/helpers/route.php',
						'class' => 'K2HelperRoute',
						'method' => 'getItemRoute'
				)
		);
		
		// Ensure to process only native Joomla/K2 articles supported contexts
		if (!array_key_exists ( $context, $this->adaptersMapping )) {
			return;
		}
		
		// Extract the correct route helper
		$routeHelper = $this->adaptersMapping [$context] ['file'];
		if (!file_exists ( $routeHelper )) {
			return;
		}
		
		// Include needed files for the correct multilanguage routing from backend to frontend of the save articles
		include_once ($routeHelper);

		// Store the context for static class method call
		$this->context = $this->adaptersMapping [$context];
			
		// Start HTTP submission process, manage users exceptions if debug is enabled
		try {
			// Try attempt to resolve the article to a single menu or container category SEF link
			if(	version_compare ( JVERSION, '3.7', '>=' ) && $context == 'com_content.article') {
				$hasArticleMenuRoute = $this->routeArticleToSefMenu ( $article->id . ':' . $article->alias, $article->catid, $article->language, $article );
			} else {
				$hasArticleMenuRoute = $this->routeArticleToSefMenu ( $article->id, $article->catid, $article->language, $article );
			}

			// If article has been resolved, fetch pings URLs from jmap_pingomatic table and do lookup
			if ($hasArticleMenuRoute) {
				
				if(	version_compare ( JVERSION, '3.7', '>=' ) && $context == 'com_content.article') {
					// Build the final article link to post
					$articleLinkToPost = trim($hasArticleMenuRoute, '/');
				} else {
					$additionalView = null;
					// K2 management
					if($context == 'com_k2.item') {
						$additionalView = 'item/';
					}
					// Build the final article link to post
					$articleLinkToPost = trim($hasArticleMenuRoute, '/') . '/' . $additionalView . $article->id . '-' . $article->alias;
					
					// Check if the SEF suffix is enabled and correct the URL
					$app = JFactory::getApplication();
					if($app->get ( 'sef_suffix', 1 )) {
						$articleLinkToPost = str_replace('.html', '', $articleLinkToPost) . '.html';
					}
				}
				
				// Share article on social networks
				$session = JFactory::getSession();
				$session->set('ifbl_autoshare_newcontent', $articleLinkToPost, 'com_instantfblogin');
			}
		} catch ( Exception $e ) {
			// Display post message after save only if debug is enabled
			if ($this->params->get ( 'enable_debug', 0 )) {
				$this->app->enqueueMessage ( $e->getMessage (), 'notice' );
			}
		}
	}
	
	/**
	 * Method to be called everytime an article form in backend is showed
	 *
	 * @param object $formObject
	 *        	A JTableContent object
	 * @param object $formData
	 *        	A JTableContent object
	 *
	 * @return boolean true if function not enabled, is in front-end or is new. Else true or
	 *         false depending on success of save function.
	 */
	public function onContentPrepareForm($formObject, $formData) {
		$app = JFactory::getApplication();
		
		// Avoid operations if the feature is not enabled
		if (! $this->params->get ( 'facebookAutoPosting', 0 )
		 && ! $this->params->get ( 'gplusAutoPosting', 0 )
		 && ! $this->params->get ( 'twitterAutoPosting', 0 )) {
			return;
		}
		
		// Avoid operations if plugin is executed in frontend
		if (!$app->isAdmin()) {
			return;
		}
		
		// Get and evaluate the session variable, inject only if valid execution after saving new articles in admin
		$session = JFactory::getSession();
		if($linkToShare = $session->get('ifbl_autoshare_newcontent', null, 'com_instantfblogin')) {
			$doc = JFactory::getDocument();
			
			// Facebook auto share enabled
			if($this->params->get('facebookAutoPosting', 0)) {
				$fbLinkToShare = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($linkToShare);
				$doc->addScriptDeclaration('window.open("' . $fbLinkToShare . '", "_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=480,height=360")');
			}

			// GPlus auto share enabled
			if($this->params->get('gplusAutoPosting', 0)) {
				$gplusLinkToShare = 'https://plus.google.com/share?url=' . rawurlencode($linkToShare);
				$doc->addScriptDeclaration('window.open("' . $gplusLinkToShare . '", "_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=480,height=360")');
			}
			
			// Twitter auto share enabled
			if($this->params->get('twitterAutoPosting', 0)) {
				$twLinkToShare = 'https://twitter.com/intent/tweet?url=' . rawurlencode($linkToShare);
				$doc->addScriptDeclaration('window.open("' . $twLinkToShare . '", "_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=300,left=300,width=480,height=360")');
			}
			
			$session->set('ifbl_autoshare_newcontent', null, 'com_instantfblogin');
		}
	}
	
	/**
	 * Class Constructor
	 *
	 * @param object $subject The object to observe
	 * @param array  $config  An optional associative array of configuration settings.
	 * Recognized key values include 'name', 'group', 'params', 'language'
	 * (this list is not meant to be comprehensive).
	 * @since 1.5
	 */
	public function __construct(&$subject, $config = array()) {
		parent::__construct($subject, $config);
		
		$lang = JFactory::getLanguage();
		$locale = $lang->getTag();
		$this->langTag = str_replace("-", "_", $locale);
		$this->langStartTag = @array_shift(explode('-', $locale));
		$this->params = JComponentHelper::getParams('com_instantfblogin');
	}
}