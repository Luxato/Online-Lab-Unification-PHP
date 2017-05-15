model HydraulikaPID
  constant Real q2=#q2# "pritok2";
  constant Real q3=#q3# "pritok3";
  constant Real ro=1 "hustota";
  constant Real g=9.81 "gravitacne zrychlenie";
  constant Real R1=8000 "hodpor1";
  constant Real R2=8000 "hodpor2";
  constant Real R3=8000 "hodpor3";
  constant Real F1=0.00785 "prierez1";
  constant Real F2=0.00785 "prierez2";
  constant Real F3=0.00785 "prierez3";
  constant Real ref = 5 "Reference level";
  Real q1(start=#q1#, fixed=true) "pritok1";
  Real h1(start=20, fixed=true) "vyska1";
  Real h2(start=5, fixed=true) "vyska2";
  Real h3(start=5, fixed=true) "vyska3";
  //PID controller part
  Real cti(start = 0, fixed = true) "State variable I for controller";
  Real ctd(start = 0, fixed = true) "State variable D for controller";
  parameter Real P = 35 "Gain";
  parameter Real Ti(unit = "s") = 1.5 "Integral time constant";
  parameter Real Td(unit = "s") = 1 "Derivation time constant";
  //parameter Real ref = 5 "Reference level";
  Real error(start = 0) "Deviation from reference level";

equation
  der(h1) = (q1-ro*g*h1/R1+ro*g*h2/R1)/F1;
  der(h2) = (q2+ro*g*(h1-h2)/R1-ro*g*(h2-h3)/R2)/F2;
  der(h3) = (q3+ro*g*(h2-h3)/R2-ro*g*h3/R3)/F3;
  //PID controller part
  error = ref - h1;
  

   
  der(cti) = if Ti > 0 then error / Ti else 0;
  ctd = Td * der(error);

  if P*(error+cti+ctd)>0 then 
	q1 = P * (error + cti + ctd);
	
	else 
	  q1=0;
  end if;

end HydraulikaPID;