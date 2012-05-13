<h2>Record Demo</h2>
<table width="100%">
<tr>
	<td valign="middle" align="center">
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			id="VideoRecorder" width="324" height="276"
			codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="../swf/VideoRecorder.swf" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#333333" />
			<param name="allowScriptAccess" value="sameDomain" />
			<embed src="../swf/VideoRecorder.swf" quality="high" bgcolor="#333333"
				width="324" height="276" name="VideoRecorder" align="middle"
				play="true"
				loop="false"
				quality="high"
				allowScriptAccess="sameDomain"
				type="application/x-shockwave-flash"
				pluginspage="http://www.adobe.com/go/getflashplayer">
			</embed>
		</object>
    </td>
</tr>
</table>

<script>
	
	function userHasCamMic(cam_number,mic_number,recorderId){
		//alert("userHasCamMic("+cam_number+","+mic_number+")");
		//this function is called when HDFVR is initialized
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function btRecordPressed(recorderId){
		//alert("btRecordPressed");
		//this function is called whenever the Record button is pressed to start a recording
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function btStopRecordingPressed(recorderId){
		//alert("btStopRecordingPressed");
		//this function is called whenever a recording is stopped
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function btPlayPressed(recorderId){
		//alert("btPlayPressed");
		//this function is called whenever the Play button is pressed to start/resume playback
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function btPausePressed(recorderId){
		//alert("btPausePressed");
		//this function is called whenever the Pause button is pressed during playback
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function onUploadDone(streamName,streamDuration,userId,recorderId){
		//alert("onUploadDone("+streamName+","+streamDuration+","+userId+")");
		
		//this function is called when the video/audio stream has been all sent to the video server and has been saved to the video server HHD, 
		//on slow client->server connections, because the data can not reach the video server in real time, it is stored in the recorder's buffer until it is sent to the server, you can configure the buffer size in avc_settings.XXX
		
		//this function is called with 3 parameters: 
		//streamName: a string representing the name of the stream recorded on the video server including the .flv extension
		//userId: the userId sent via flash vars or via the avc_settings.XXX file, the value in the avc_settings.XXX file takes precedence if its not empty
		//duration of the recorded video/audio file in seconds but acccurate to the millisecond (like this: 4.322)
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function onSaveOk(streamName,streamDuration,userId,cameraName,micName,recorderId){
		//alert("onSaveOk("+streamName+","+streamDuration+","+userId+","+cameraName+","+micName+")");
		
		//the user pressed the [save] button inside the recorder and the save_video_to_db.XXX script returned save=ok
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function onSaveFailed(streamName,streamDuration,userId,recorderId){
		//alert("onSaveFailed("+streamName+","+streamDuration+","+userId+")");	
		
		//the user pressed the [save] button inside the recorder but the save_video_to_db.XXX script returned save=fail
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	function onSaveJpgOk(streamName,userId,recorderId){
		//alert("onSaveJpgOk("+streamName+","+userId+")");
		
		//the user pressed the [save] button inside the recorder and the save_video_to_db.XXX script returned save=ok
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function onSaveJpgFailed(streamName,userId,recorderId){
		//alert("onSaveJpgFailed("+streamName+","+userId+")");	
		//the user pressed the [save] button inside the recorder but the save_video_to_db.XXX script returned save=fail
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function onFlashReady(recorderId){
		//alert("onFlashReady()");
		//you can now communicate with HDFVR using the JS Control API
		//Example : document.VideoRecorder.record(); will make a call to flash in order to start recording
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	function onPlaybackComplete(recorderId){
		//alert("onPlaybackComplete()")
		//this function is called when HDFVR plays back a recorded video and the playback completes
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
	}
	
	
	function onCamAccess(allowed,recorderId){
		//alert("onCamAccess("+allowed+")");
		//the user clicked Allow or Deny in the Camera/Mic access dialog box in Flash Player
		//when the user clicks Deny this function is called with allowed=false
		//when the user clicks Allow this function is called with allowed=true
		//you should wait for this function before allowing the user to cal the record() function on HDFVR
		//this function can be called anytime during the life of the HDFVR instance as the user has permanent access to the Camera/Mic access dialog box in Flash Player
		//recorderId: the recorderId sent via flash vars, to be used when there are many recorders on the same web page
		if (allowed){
			document.getElementById("recordbtn").disabled = false
		}else{
			document.getElementById("recordbtn").disabled = true
		}
	}
</script>