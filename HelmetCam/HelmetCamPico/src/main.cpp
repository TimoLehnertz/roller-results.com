#include <Arduino.h>
#include <crossfire.h>
#include <Wire.h>
#include <Servo.h>

#define PIN_O3 15
#define PIN_GIMBAL 18
#define PIN_BAT_ADC 26

#define SERVOMIN  150 // This is the 'minimum' pulse length count (out of 4096)
#define SERVOMAX  600 // This is the 'maximum' pulse length count (out of 4096)
#define USMIN  600 // This is the rounded 'minimum' microsecond length based on the minimum pulse of 150
#define USMAX  2400 // This is the rounded 'maximum' microsecond length based on the maximum pulse of 600
#define SERVO_FREQ 50 // Analog servos run at ~50 Hz updates

UART Serial2(8, 9, 0, 0); // elrs
UART Serial3(12, 13, 0, 0); // dji o3

Crossfire crsf(&Serial2);

Servo servo;

void setup() {
  pinMode(LED_BUILTIN, OUTPUT);
  pinMode(PIN_O3, OUTPUT);
  pinMode(PIN_GIMBAL, OUTPUT);
  digitalWrite(LED_BUILTIN, HIGH);
  Serial.begin(CRSF_BAUDRATE);
  Serial3.begin(CRSF_BAUDRATE);
  Serial2.begin(CRSF_BAUDRATE);
  servo.attach(PIN_GIMBAL);
  servo.write(90); // start pos
  crsf.begin();
  analogReadResolution(12);
}

float interpolate(float x, float x1, float y1, float x2, float y2) {
    return y1 + (x - x1) * (y2 - y1) / (x2 - x1);
}

void loop() {
  crsf.handle();
  while(Serial2.available()) {
    char c = Serial2.read();
    crsf.encode(c);
  }
  CRSF_TxChanels_Converted channels = crsf.getChanelsCoverted();
  bool vtxEnable = channels.aux1 > 0;
  float gimbalPos = (channels.throttle * (-1) + 0.5) * 0.58 + 0.47;
  if(!crsf.firstFrameReceived) {
    vtxEnable = true;
    gimbalPos = 0.5; 
  }
  if(vtxEnable) {
    digitalWrite(LED_BUILTIN, HIGH);
  } else {
    digitalWrite(LED_BUILTIN, millis() % 1000 < 500); 
  }
  digitalWrite(PIN_O3, vtxEnable);

  float bat = analogRead(PIN_BAT_ADC) * (3.3 / 4095.0) * 3.2 * 1.0670103;
  float remainingPercent;
  if (bat >= 9.0) {
      remainingPercent = 100;
  } else if (bat <= 6.6) {
      remainingPercent = 0;
  } else {
      remainingPercent = interpolate(bat, 6.6, 0, 9.0, 100);
      remainingPercent = remainingPercent < 0 ? 0 : remainingPercent;
      remainingPercent = remainingPercent > 100 ? 100 : remainingPercent;
  }
  crsf.updateTelemetryBattery(bat, 0, 0, remainingPercent);

  servo.write(gimbalPos * 180);
}