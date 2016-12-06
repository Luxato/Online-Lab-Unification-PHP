model DampedHarmonicOscillator
  parameter Real f=40 "force";
  constant Real m=10 "mass of body";
  constant Real kp=20 "spring constant";
  constant Real kt=2 "damper constant";
  constant Real g=9.81 "gravity acceleration";
  Real y(start=5, fixed=true) "position";
  Real v(start=0, fixed=true) "velocity";

equation
  der(y) = v;
  der(v) = -kp*y/m-kt*v/m+f/m+g;

end DampedHarmonicOscillator;
