We don't have PHP example.

For web application, we have a SDK web client ( for Windows only ), please download from here - https://drive.google.com/file/d/1YxemHHibhO6becGBOL1VeKgQnnsH-HM7/view?usp=sharing. It works on Chrome, Edge, FireFox and Opera browsers.
 
After downloaded, please unzip to the client machine, run 'FPHttpServer.msi' to install the service, and then test with the main.html.
 
-  For ANSI/ISO SDK (https://www.futronic-tech.com/pro-detail.php?pro_id=1541, the price is US$1000 per copy ), you can do as below:
 
    1. Enrollment -
        ANSI format template: Click button 'Enroll ANSI Sdk', the return template is ANSI format, send the data to your backend server and save to database by yourself.
        ISO format template:  Check ‘Convert ANSI to ISO’ checkbox,  click button 'Enroll ANSI Sdk', the return template is ISO format, send the data to your backend server and save to database by yourself. 
 
    2. Identification - uncheck 'Convert ANSI to ISO' checkbox, then click button 'Enroll ANSI Sdk', the return tempalte is ANSI format, send the data to your backend server and then do the 'Identify'.
 
-  For Futronic Standard SDK (https://www.futronic-tech.com/pro-detail.php?pro_id=1555, you can request a free version from the end of the page ), you can do as below:
 
    1. Enrollment – Click button ‘Enroll FTRAPI(Template)’, the return data is the Template data, send it to your backend server and save to database by yourself.
 
    2. Identification – Click button ‘Enroll FTRAPI(Sample)’, the return data is the Sample data, send it to your backend server, set it as baseTemplate and do the ‘Identify’.
 
    And you can also refer to our online demo - http://210.3.41.254//demo.html.   ( js + html )
    // for example:
    //retrieve the template data byte[] from string
    string strTmplate = Request["fptemplate"].ToString();
    byte[] decode_tmplate = Convert.FromBase64String(strTmplate);
    //......
    FutronicSdkBase m_Operation = new FutronicIdentification();
    ((FutronicIdentification)m_Operation).FARN = 245;
    ((FutronicIdentification)m_Operation).BaseTemplate = decode_tmplate; // the Sample sent from client
    nResult = ((FutronicIdentification)m_Operation).Identification(rgRecords, ref iIndex); // rgRecords are the saved templates.
    //...... for more details, please refer to the SDK example source code.
 
-  Capture image only, you can click the button ‘Capture Frame’, the return data is RAW image, send it to your backend server and process by yourself.

Thanks.