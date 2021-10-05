#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

const char *ssid = "00000000 2.4";
const char *password = "";
String webServerUI = "https://keluke.000webhostapp.com/dispenser.php";
const char webServerAddData1[] PROGMEM = "http://keluke.000webhostapp.com/from_micro.php?D1=%d";
char webServerAddData[100] = "";
String makeRequest();
int ultrasonicSensor();
String payload;

// Ultrasonic Sensor
const int trigPin = 2;  //D4
const int echoPin = 0;  //D3
int distance;

void setup()
{
  // Ultrasonic Sensor
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  
  Serial.begin(115200);
  WiFi.begin(ssid, password);
}

void loop()
{
  delay(5000);  // Checking for new data every 5 seconds

  distance = ultrasonicSensor();
  if (distance < 20){
    // Data Formatting
    sprintf_P(webServerAddData,webServerAddData1,distance);
    payload = makeRequest();
  };
}
