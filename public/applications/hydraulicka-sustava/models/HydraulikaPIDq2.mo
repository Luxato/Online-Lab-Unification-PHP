model HydraulikaPIDq2
  constant Real ro=1 "hustota";
  constant Real g=9.81 "gravitacne zrychlenie";
  constant Real R1=8000 "hodpor1";
  constant Real R2=8000 "hodpor2";
  constant Real R3=8000 "hodpor3";
  constant Real F1=0.00785 "prierez1";
  constant Real F2=0.00785 "prierez2";
  constant Real F3=0.00785 "prierez3";
  constant Real ref = 25 "Reference level";
  Real q2(start=0) "pritok2";
  Real h1(start=5, fixed=true) "vyska1";
  Real h2(start=15, fixed=true) "vyska2";
  Real h3(start=14.6, fixed=true) "vyska3";
  //PID controller part
  Real cti(start = 0) "State variable I for controller";
  Real ctd(start = 0) "State variable D for controller";
  parameter Real P = 35 "Gain";
  parameter Real Ti(unit = "s") = 1.5 "Integral time constant";
  parameter Real Td(unit = "s") = 1 "Derivation time constant";
  //parameter Real ref = 25 "Reference level";
  Real error(start = 0) "Deviation from reference level";

equation
  if h1 < 29 then
	der(h1) = (-ro*g*h1/R1+ro*g*h2/R1)/F1;
	
	else if ((-ro*g*h1/R1+ro*g*h2/R1)/F1)<0 then
			der(h1) = (-ro*g*h1/R1+ro*g*h2/R1)/F1;
		 else der(h1)=0;
		 end if;
  end if;
	
  if h2 < 29 then
	der(h2) = (q2+ro*g*(h1-h2)/R1-ro*g*(h2-h3)/R2)/F2;
	
	else if ((q2+ro*g*(h1-h2)/R1-ro*g*(h2-h3)/R2)/F2)<0 then
			der(h2) = (q2+ro*g*(h1-h2)/R1-ro*g*(h2-h3)/R2)/F2;
		 else der(h2)=0;
		 end if;
  end if;
  
  if h3 < 29 then
	der(h3) = (ro*g*(h2-h3)/R2-ro*g*h3/R3)/F3;
	
	else if ((ro*g*(h2-h3)/R2-ro*g*h3/R3)/F3)<0 then
			der(h3) = (ro*g*(h2-h3)/R2-ro*g*h3/R3)/F3;
		 else der(h3)=0;
		 end if;
  end if;
  //PID controller part
  error = ref - h2;
  

   
  der(cti) = if Ti > 0 then error / Ti else 0;
  ctd = Td * der(error);

  if P*(error+cti+ctd)>0 then 
	q2 = P * (error + cti + ctd);
	
	else 
	  q2=0;
  end if;

end HydraulikaPIDq2;