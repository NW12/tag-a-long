<html lang='en_us'><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body><style type="text/css"><!--
        form#WebToLeadForm, form#WebToLeadForm * {margin: 0; padding: 0; border: none; color: #333; font-size: 12px; line-height: 1.6em; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;} form#WebToLeadForm {float: right;background:rgba(0,154,68,0.7);     width: 66%;   border-radius: 10px;  margin: 10px;} form#WebToLeadForm h1 {font-size: 32px; font-weight: bold; background-color: rgb(60, 141, 188); color: rgb(247, 247, 247); padding: 10px 20px;} form#WebToLeadForm h2 {font-size: 24px; font-weight: bold;  color: rgb(247, 247, 247); padding: 5px 20px;} form#WebToLeadForm h3 {font-size: 12px; font-weight: bold; padding: 10px 20px;} form#WebToLeadForm h4 {font-size: 10px; font-weight: bold; padding: 10px 20px;} form#WebToLeadForm h5 {font-size: 8px; font-weight: bold; padding: 10px 20px;} form#WebToLeadForm h6 {font-size: 6px; font-weight: bold; padding: 10px 20px;} form#WebToLeadForm p {padding: 10px 20px;} form#WebToLeadForm input, form#WebToLeadForm select, form#WebToLeadForm textarea {border: 1px solid #ccc; display: block; float: left; min-width: 170px; padding: 5px;} form#WebToLeadForm select {background-color: white;} form#WebToLeadForm input[type="button"], form#WebToLeadForm input[type="submit"] {display: inline; float: none; padding: 5px 20px;color:#fff;font-size:15px;border:none;background:#ef3054; width: auto; min-width: auto;} form#WebToLeadForm input[type="checkbox"], form#WebToLeadForm input[type="radio"] {width: 18px; min-width: auto;} form#WebToLeadForm div.col {display: block; float: left; width:100%; padding: 4px 20px;} form#WebToLeadForm div.clear {display: block; float: none; clear: both; height: 0px; overflow: hidden;} form#WebToLeadForm div.center {text-align: center;} form#WebToLeadForm div.buttons {padding: 10px 0;7} form#WebToLeadForm label {display: block; float: left; width: 160px; font-weight: bold;} form#WebToLeadForm span.required {color: #FF0000;} 
                --></style>
        <form id="WebToLeadForm" action="http://176.58.88.16/index.php?entryPoint=WebToPersonCapture" method="POST" name="WebToLeadForm">
            <h2></h2>
            <div class="row">
                <div class="col"><label>First Name: <span class="required">*</span></label><input name="first_name" id="first_name" placeholder="Enter Name" type="text" required=""/></div>
                <div class="col"></div>
                <div class="clear"></div>
            </div>
            <div class="row">
                <div class="col"><label>Last Name: <span class="required">*</span></label><input name="last_name" id="last_name" placeholder="Enter Name" type="text" required="" /></div>
                <div class="col"></div>
                <div class="clear"></div>
            </div>
            <div class="row">
                <div class="col"><label>Phone: <span class="required">*</span></label><input name="phone_work" id="phone_work" placeholder="Cell No." type="text" required="" /></div>
                <div class="col"></div>
                <div class="clear"></div>
            </div>
            <div class="row">
                <div class="col"><label>Email Address: <span class="required">*</span></label><input name="email1" id="email1" type="email" placeholder="Email" required="" /></div>
                <div class="col"></div>
                <div class="clear"></div>
            </div>
            <div class="row">
                <div class="col"><label>Best time to call: <span class="required">*</span></label><select name="best_time_to_call" id="best_time_to_call" required><option value="10am">10am</option><option value="11am">11am</option><option value="12am">12am</option><option value="1pm">1pm</option><option value="2pm">2pm</option><option value="3pm">3pm</option><option value="4pm">4pm</option><option value="5pm">5pm</option><option value="6pm">6pm</option><option value="7pm">7pm</option></select></div>
                <div class="col"></div>
                <div class="clear"></div>
            </div>
            <div class="row center buttons"><input class="button" name="Submit" type="submit" value="Next" onclick="submit_form();" />
                <div class="clear"></div>
            </div>
            <input name="campaign_id" id="campaign_id" type="hidden" value="81a9aac3-824c-53e2-7ce7-5847746579f1" /> <input name="redirect_url" id="redirect_url" type="hidden" value="http://ecofundingplan.com/thank-you" /> <input name="assigned_user_id" id="assigned_user_id" type="hidden" value="1" /> <input name="moduleDir" id="moduleDir" type="hidden" value="Leads" /></form>
        <p>
            <script type="text/javascript">// <![CDATA[
                function submit_form() { if (typeof (validateCaptchaAndSubmit) != 'undefined') { validateCaptchaAndSubmit(); } else { check_webtolead_fields(); //document.WebToLeadForm.submit(); } } function check_webtolead_fields() { if (document.getElementById('bool_id') != null) { var reqs = document.getElementById('bool_id').value; bools = reqs.substring(0, reqs.lastIndexOf(';')); var bool_fields = new Array(); var bool_fields = bools.split(';'); nbr_fields = bool_fields.length; for (var i = 0; i < nbr_fields; i++) { if (document.getElementById(bool_fields[i]).value == 'on') { document.getElementById(bool_fields[i]).value = 1; } else { document.getElementById(bool_fields[i]).value = 0; } } } } 
                // ]]></script>
        </p></body></html>