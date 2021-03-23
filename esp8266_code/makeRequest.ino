String makeRequest()
{
  if (WiFi.status() == WL_CONNECTED)
  {
//    Serial.println("Wifi Connected Success!");
//    Serial.print("NodeMCU IP Address : ");
//    Serial.println(WiFi.localIP());

    WiFiClient client;
    HTTPClient http;
    HTTPClient httpMakeRequest;
    String payload;

    httpMakeRequest.begin(client, webServerAddData);
    int httpMRCode = httpMakeRequest.GET();
    Serial.printf("httpMRCode: %d\n", httpMRCode);

    Serial.print("[HTTP] begin...\n");
    if (http.begin(client, webServerUI)) // client is what type of network are u using. wifi, ethernet, gsm.
    { 

      Serial.print("[HTTP] GET...\n");
      int httpCode = http.GET();    // start connection and send HTTP header
      
      if (httpCode > 0)   // httpCode will be negative on error
      {
        Serial.printf("[HTTP] GET... code: %d\n", httpCode);

        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY)
        {
          payload = http.getString();
//          Serial.println(payload);
        }
      }
      else
      {
        Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
      }

      http.end();
    }
    else
    {
      Serial.printf("[HTTP] Unable to connect\n");
    }
    return payload;
  }
  else
  {
    Serial.println("Unable to connect to the WiFi");
    return "[ERROR]";
  }
}
