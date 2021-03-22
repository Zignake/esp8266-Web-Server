#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

const char *ssid = "00000000 2.4";
const char *password = "ballerina";

void setup()
{

  Serial.begin(115200);
  // Serial.setDebugOutput(true);

  WiFi.begin(ssid, password);
}

void loop()
{
  // wait for WiFi connection

  if (WiFi.status() == WL_CONNECTED)
  {
    Serial.println("Wifi Connected Success!");
    Serial.print("NodeMCU IP Address : ");
    Serial.println(WiFi.localIP());

    WiFiClient client;
    HTTPClient http;
    HTTPClient httpMakeRequest;

    httpMakeRequest.begin(client, "http://keluke.000webhostapp.com/from_micro.php?unit=1&sensor=140");
    int httpMRCode = httpMakeRequest.GET();
    Serial.printf("httpMRCode: %d\n", httpMRCode);

    Serial.print("[HTTP] begin...\n");
    if (http.begin(client, "http://keluke.000webhostapp.com/interface.php"))
    { // client is what type of network are u using. wifi, ethernet, gsm.

      Serial.print("[HTTP] GET...\n");
      // start connection and send HTTP header
      int httpCode = http.GET();

      // httpCode will be negative on error
      if (httpCode > 0)
      {
        // HTTP header has been sent and Server response header has been handled
        Serial.printf("[HTTP] GET... code: %d\n", httpCode);

        // file found at server
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY)
        {
          String payload = http.getString();
          Serial.println("start");
          Serial.println(payload);
          Serial.println("end");
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
      Serial.printf("[HTTP} Unable to connect\n");
    }
  }

  delay(10000);
}
