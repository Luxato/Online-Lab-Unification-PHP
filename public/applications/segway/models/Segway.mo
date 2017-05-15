model Segway
  // Parametre systemu
  parameter Real mB(unit = "kg") = 15 "hmotnost  tela robota TWIP";
  parameter Real mW(unit = "kg") = 0.42 "hmotnost kazdeho kolesa ";
  parameter Real L(unit = "m") = 0.2 "vzdialenost kolies/2";
  parameter Real R(unit = "m") = 0.106 "polomer kolies  ";
  parameter Real d(unit = "m") = 0.212 "vzdialenost medzi stredom spojnice osi kolies a taziskom";
  parameter Real I2(unit = "kgm^2") = 0.63 "moment zotrvacnosti tela v smere n2";
  parameter Real I3(unit = "kgm^2") = 1.12 "moment zotrvacnosti tela v smere n3";
  parameter Real g(unit = "ms^-2") = 9.81 "gravitacna konstanta";
  parameter Real phi2Max(unit = "ms^-2") = 3.14 / 4 + 3.14 / 6 "hranice pre uhol";
  Real phi(start = 0.5235987755982988, unit = "rad") "uhol natocenia  kyvadlo- vstup";
  Real derphi(start = 0, unit = "rad/s^-1") "uhlova rychlost kyvadlo- vystup";
  Real psi(start = 0, unit = "rad") "orientacia natocenia motory- vstup";
  Real derpsi(start = 0, unit = "rad/s^-1") "uhlova rychlost natocenia kyvadlo- vystup";
  Real x(start = 0, unit = "m") "poloha";
  Real derx(start = 5, unit = "ms^-1") "rychlost";
  Real alfa3(start = 0, unit = "1") "alfa";
  Real beta3(start = 0, unit = "1") "beta";
  //PID controller part
  Real cti(start = 0, fixed = true) "State variable I for controller";
  Real ctd(start = 0, fixed = true) "State variable D for controller";
  parameter Real P = 18 "Gain 18";
  parameter Real Ti(unit = "s") = 20 "Integral time constant 20";
  parameter Real Td(unit = "s") = 0.1 "Derivation time constant 0.1";
  parameter Real ref = 0 "Reference level";
  //Real error(start = 0) "Deviation from reference level";
  //Real u(start = 0) "akcny zasah";
  //Real y(start = 0) "vystup";
  Real error "Deviation from reference level";
  Real u "akcny zasah";
  Real y "vystup";
equation
  //  when time > 0 then
  //    reinit(phi, 0.5);
  //  end when;
  //vystup a vstup
  y = phi;
  alfa3 = -u / 2;
  beta3 = -u / 2;
  //derivacie
  derphi = der(phi);
  derpsi = der(psi);
  derx = der(x);
  //rovnice
  0 = (alfa3 + beta3) / R + (3 * mW + mB) * der(derx) - mB * d * cos(phi) * der(derphi) + (derpsi * derpsi + derphi * derphi) * mB * d * sin(phi);
  0 = (alfa3 - beta3) * L / R + (mW * (3 * L * L + R * R / 2) + mB * d * d * sin(phi) * sin(phi) + I2) * der(derpsi) + mB * d * d * sin(phi) * cos(phi) * derphi * derpsi;
  0 = mB * g * d * sin(phi) - (alfa3 + beta3) + mB * d * cos(phi) * der(derx) - (mB * d * d + I3) * der(derphi) + mB * d * d * sin(phi) * cos(phi) * derpsi * derpsi;
  //PID controller part
  error = ref - y;
  der(cti) = if Ti > 0 then error / Ti else 0;
  ctd = Td * der(error);
  u = P * (error + cti + ctd);
end Segway;