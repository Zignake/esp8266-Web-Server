#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

const char *ssid = "00000000 2.4";
const char *password = "ballerina";
String webServerUI = "http://keluke.000webhostapp.com/interface.php";
String webServerAddData = "http://keluke.000webhostapp.com/from_micro.php?led=25&sensor=25";

String makeRequest();
String payload;

void setup()
{
  Serial.begin(115200);
  WiFi.begin(ssid, password);
}

void loop()
{
  delay(5000);
  payload = makeRequest();
  Serial.println(payload); 
}
