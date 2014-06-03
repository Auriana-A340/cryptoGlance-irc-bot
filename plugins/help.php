<?php

class Plugin_Help implements Plugin_Interface {

	var $config;
	var $socket;
	
	// Replacable data
	var $_from;
	var $_channel;

    function init($config, $socket) {
	    $this->config = $config;
	    $this->socket = $socket;
    }

    function tick() { }

    function onMessage($from, $channel, $msg) {
        $this->_from = $from;
        $this->_channel = $channel;
        if(stringStartsWith($msg, "{$this->config['trigger']}help")) {
            $bits = explode(" ", $msg);
		    $subject = @$bits[1];
		    $params = @$bits[2];
		    
		    if (!empty($subject)) {
		        switch ($subject) {
		            case 'rigs':
		                $this->rigs($params);
		                break;
		            case 'pools':
		                $this->pools($params);
		                break;
		            case 'wallets':
		                $this->pools($params);
		                break;
		            case 'other':
		                sendMessage($this->socket, $this->_channel, "{$this->_from}: Please refer to our README: https://github.com/cryptoGlance/cryptoGlance-web-app/blob/master/README.md");
		                sendMessage($this->socket, $this->_channel, "{$this->_from}: If your problem is not identified in the README, please leave your question message here, or ask on our reddit (best solution): http://www.reddit.com/r/cryptoglance");
		                break;
		            default:
		                sendMessage($this->socket, $this->_channel, "{$this->_from}: I didn't understand that. Please only use commands displayed with !help");
		                break;
		        }
		    } else {
//		        sendMessage($this->socket, $this->_channel, "{$this->_from}: Useful Commands: !latest, !git, !reddit, !forums, !website, !suggestion");
		        sendMessage($this->socket, $this->_channel, "{$this->_from}: If you need help troubleshooting, please use !help <subject>. Available subjects are: rigs, pools, wallets, other. Example: \"!help rigs\"");
		    }
        }
    }
    
    function rigs($params = null) {
        if (is_null($params)) {
		    sendMessage($this->socket, $this->_channel, "{$this->_from}: Please pick one of the following using !help rigs <option>. Example \"!help rigs 2\"");
		    sendMessage($this->socket, $this->_channel, "{$this->_from}: 1 - How do I add a rig?");
		    sendMessage($this->socket, $this->_channel, "{$this->_from}: 2 - After adding rig, it sits there loading.");
		    sendMessage($this->socket, $this->_channel, "{$this->_from}: 3 - How do I remove a rig?");
		    sendMessage($this->socket, $this->_channel, "{$this->_from}: 4 - How do I add/edit/remove pools?");
        } else {
            switch ($params) {
	            case '1':
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: To add a rig, click the green + button in the top navbar beside \"Dashboard\".");
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: If your page doesn't refresh after adding a rig, make sure \"user-data\" folder is writable. (for Linux users only)");
	                break;
	            case '2':
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: There are many reasons why a rig may not load properly. Suggestions are:");
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: a) Using Windows App: If cryptoGlance is installed to C:\Program Files, run cryptoGlance.exe as Administrator (right click, Run as Administrator), or re-install to C:\cryptoGlance");
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: b) Using Windows App: Is the firewall enabled? Check to see if cryptoGlance is being blocked by the firewall.");
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: c) Check if cgminer is running and verify you have the right IP entered. If everything is entered into cryptoGlance correctly, make sure your API config is correctly set up. Please see the README: ttps://github.com/cryptoGlance/cryptoGlance-web-app/blob/master/README.md");
	                break;
	            case '3':
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: To remove a rig, click the X on the top right of the Rig Panel.");
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: If your page doesn't refresh after removing a rig, make sure \"user-data\" folder is writable. (for Linux users only)");
	                break;
	            case '4':
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: This functionality is not ready. It will be available for next release :)");
	                break;
	            default:
	                sendMessage($this->socket, $this->_channel, "{$this->_from}: I didn't understand that. Please only use the numbers provided.");
	                break;
	        }
        }
    }
    
    function pools($params = null) {
	    sendMessage($this->socket, $this->_channel, "{$this->_from}: Help not available yet for pools");
	    sendMessage($this->socket, $this->_channel, "{$this->_from}: If you'd like us to support your pool, please direct us to your API here: http://www.reddit.com/r/cryptoglance/comments/231a67/pool_requests/");
    }
    
    function wallets($params = null) {
	    sendMessage($this->socket, $this->_channel, "{$this->_from}: Help not available yet for wallets");
	    sendMessage($this->socket, $this->_channel, "{$this->_from}: PLEASE NOTE: We do not have full access to your wallet! We utilize public APIs and calculate your balance through the blockchain.");
    }

    function destroy() { }
}
