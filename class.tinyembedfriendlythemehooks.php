<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

class TinyEmbedFriendlyThemeHooks implements Gdn_IPlugin {
	
   public function Setup() {
		// Set the order for the modules (make sure new discussion module is before content).
		SaveToConfig('Modules.Vanilla.Content', array('MessageModule', 'Notices', 'NewConversationModule', 'NewDiscussionModule', 'Content', 'Ads'));
		SaveToConfig('Modules.Conversations.Content', array('MessageModule', 'Notices', 'NewConversationModule', 'NewDiscussionModule', 'Content', 'Ads'));
   }

   public function OnDisable() {
      return TRUE;
   }
	
	public function SettingsController_AfterCurrentTheme_Handler($Sender) {
		$SingleColumn = C('Themes.TinyEmbedFriendly.SingleColumn');
		echo Wrap(
			T('This theme allows you to hide the side panel next to your forum and conversations. This is super handy if the website you are embedding in does not have a lot of width to squeeze into.')
			.Wrap(Anchor(
				T($SingleColumn ? 'Show the side panel' : 'Hide the side panel'),
				'settings/tinyembedfriendlytogglepanel/'.Gdn::Session()->TransientKey(),
				'SmallButton'
			), 'div')
		, 'div', array('class' => 'Description'));
	}
	
	public function SettingsController_TinyEmbedFriendlyTogglePanel_Create($Sender) {
		$this->_TogglePanel($Sender);
		Redirect('settings/themes');
	}
	
	public function PluginController_BeforeEmbedRecommend_Handler($Sender) {
		$SingleColumn = C('Themes.TinyEmbedFriendly.SingleColumn');
		echo '<div class="EmbedRecommend">
			<strong>Theme Options</strong>'
			.Wrap(
				T('This theme allows you to hide the side panel next to your forum and conversations. This is handy if the website you are embedding in does not have a lot of width to fit into.')
				.Wrap(Anchor(
					T($SingleColumn ? 'Show the side panel' : 'Hide the side panel'),
					'plugin/tinyembedfriendlytogglepanel/'.Gdn::Session()->TransientKey(),
					'SmallButton'
				), 'div', array('style' => 'margin-top: 10px;'))
			, 'em')
		.'</div>';
	}
	
	public function PluginController_TinyEmbedFriendlyTogglePanel_Create($Sender) {
		$this->_TogglePanel($Sender);
		Redirect('plugin/embed');
	}

	private function _TogglePanel($Sender) {
		$Sender->Permission('Garden.Themes.Manage');
		$TransientKey = GetValue(0, $Sender->RequestArgs);
		if (Gdn::Session()->ValidateTransientKey($TransientKey))
			SaveToConfig('Themes.TinyEmbedFriendly.SingleColumn', C('Themes.TinyEmbedFriendly.SingleColumn') ? FALSE : TRUE);
	}


	public function Base_Render_Before($Sender) {
		if (($Sender->MasterView == 'default' || $Sender->MasterView == '') && C('Themes.TinyEmbedFriendly.SingleColumn'))
			$Sender->AddCSSFile('singlecolumn.css');
                        
	}
	
   
   public function CategoriesController_Render_Before($Sender) {

	
$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));		
$photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));
}
   
   public function DiscussionsController_Render_Before($Sender) {

$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));		

                            $photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));
}


   public function DiscussionController_Render_Before($Sender) {

$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('/themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));			
$photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications')); 	
 
  }

   public function DraftsController_Render_Before($Sender) {

$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('/themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));		
$photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));
   }
	
	public function MessagesController_Render_Before($Sender) {

$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('/themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));		
$photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));	
	}
	
          public function ProfileController_Render_Before($Sender) {

$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('/themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));		
$photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));	
	}

  public function ActivityController_Render_Before($Sender) {

$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('/themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));		
$photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));	
	}
public function PluginController_Render_Before($Sender) {

$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('/themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));		
$photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));	
	}

public function PostController_Render_Before($Sender) {

$Sender->Menu->AddLink('Categories', T('Categories'), '/categories/all');
$Sender->Menu->AddLink('Home', Img('themes/TinyEmbedFriendly/design/images/hicon.png', array('title' => T('Home'))), 'http://www.yoursite.com',  array('class' => 'Button'));
$Sender->Menu->AddLink('Games', Img('/themes/TinyEmbedFriendly/design/images/smile.png', array('title' => T('Games'))), 'plugin/Games',  array('class' => 'Button'));
$Sender->Menu->AddLink('NewDiscussion', Img('themes/TinyEmbedFriendly/design/images/new.png', array('title' => T('Start New Discussion'))), 'post/discussion',  array('class' => 'Button'));		
$photo = UserPhoto(Gdn::Session()->User);
   


$Sender->Menu->AddLink('User',  $photo,  '/profile/{UserID}/{Username}',array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));	
	}
	
        	private function _AddButton($Sender, $ModuleName) {
		if (C('Themes.TinyEmbedFriendly.SingleColumn'))
			$Sender->AddModule($ModuleName, 'Content');
	}
   
}