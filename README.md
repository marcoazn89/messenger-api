Messenger Api
-------------

Requirements
-------------
- php 7.0+

Examples
--------
Listen to messages:

```php
try {
    $service = new WebhookService();

    $eventData = json_decode(file_get_contents('php://input'), true);

    foreach ($service->processData($eventData['entry']) as $obj) {
        switch ($obj->getType()) {
            case Message::TYPE_READ:
                // Do something for read events
                break;
            case Message::TYPE_DELIVERY:
                // Do something for delivery events
                break;
            case Message::TYPE_POSTBACK:
                // Do something with the postback
                break;
            case Message::TYPE_TEXT:
            case Message::TYPE_ATTACHMENT:
                foreach ($obj->getRecievedMessage() as $message) {
                    // Do something with the messages
                }
                break;
        }
    }
} catch (Throwable $e) {
    // Something went wrong
}
```

Get User Profile:
```php
try {
	$api = new GraphApi(new GuzzleHttp\Client(), [
	    'api' => '',
	    'version' => 'v2.6',
	    'token' => ''
	]);

	$profile = $api->getUserData("1049225035154243");
} catch (Throwable $e) {
	// Something went wrong
}
```

Send messages:
```php
try {
    $api = new GraphApi(new GuzzleHttp\Client(), [
        'api' => '',
        'version' => 'v2.6',
        'token' => ''
    ]);

    //---------Quick reply example-----------------
    // Set a recipient
    $recipient = new Recipient();
    $recipient->setId('');
    
    // Create a message
    $msg = new Message();
    // Add Recipient
    $msg->setRecipient($recipient);

    // Make a text quick reply
    $qk1 = new QuickReply(QuickReply::TEXT);
    $qk1->setTitle('Quick Reply Title');
    $qk1->setPayload('qk_text_p');

    // Make a location quick reply
    $location = new QuickReply(QuickReply::LOCATION);

    // Bundle them up
    $quickReplies = [];
    $quickReplies[] = $qk1;
    $quickReplies[] = $location;

    // Set text
    $msg->setText(new Text("Pick one", $quickReplies));
    
    // Set image
    //$msg->setAttachment(new Image("https://s-media-cache-ak0.pinimg.com/736x/18/62/4c/18624c78b3b61c56b3639c7aaa222871--funny-sayings-funny-memes.jpg", $quickReplies));


    // Set Location
    //$location = new Location(['lat' => 40.68571, 'long' => -73.99103]);
    //$location->setUrl("some whitelisted url");
    //$location->setTitle('Camp');
    //$msg->setAttachment($location);

    // send message
    $result = $api->sendMessage($msg);
    //-------End of Quick reply example----------

    //------Buttons Template Example---------------
    // Create a message
    $msg = new Message();
    // Add Recipient
    $msg->setRecipient($recipient);

    // Make a url button
    $buttonWeb = new Button(Button::TYPE_WEB);
    $buttonWeb->setUrl("some whitelisted url");
    $buttonWeb->setTitle("Go to Webview");
    $buttonWeb->setWebviewHeight(Button::WEBVIEW_COMPACT);

    // Make a postback button
    $buttonPostback = new Button(Button::TYPE_POSTBACK); 
    $buttonPostback->setTitle('Send action');
    $buttonPostback->setPayload('button_postback');

    // Bundle them up
    $buttons = [];
    $buttons[] = $buttonWeb;
    $buttons[] = $buttonPostback;

    // Make a new button template
    $template = new Template(Template::TYPE_BUTTON);
    $template->setText('What do you want?');
    $template->setButtons($buttons);

    // Add attachment to message
    $msg->setAttachment($template);

    // send message
    $result = $api->sendMessage($msg);
    //--------End Buttons Template Example--------

    //--------Generic Template Example-----------
    // Create a message
    $msg = new Message();
    // Add Recipient
    $msg->setRecipient($recipient);

    // Make a url button
    $buttonWeb = new Button(Button::TYPE_WEB);
    $buttonWeb->setUrl("some whitelisted url");
    $buttonWeb->setTitle("Go to Webview");
    $buttonWeb->setWebviewHeight(Button::WEBVIEW_COMPACT);

    // Make a postback button
    $buttonPostback = new Button(Button::TYPE_POSTBACK); 
    $buttonPostback->setTitle('Send action');
    $buttonPostback->setPayload('button_postback');

    // Bundle them up
    $buttons = [];
    $buttons[] = $buttonWeb;
    $buttons[] = $buttonPostback;

    // Make a generic template
    $template = new Template(Template::TYPE_GENERIC);

    // Make an element and add buttons
    $elm1 = new Element('Element A', $buttons);
    $elm1->setSubtitle('Testing element A');
    // Make another element and add buttons
    $elm2 = new Element('Element B', $buttons);
    $elm2->setSubtitle('Testing element B');

    // bundle them up
    $elements = [];
    $elements[] = $elm1;
    $elements[] = $elm2;

    // Add elements to template
    $template->setElements($elements);

    // Add attachment to template
    $msg->setAttachment($template);

    // send message
    $result = $api->sendMessage($msg);
    
    //--------End of Generic Template----------------
} catch (Throwable $e) {
    // Something went wrong
}
```