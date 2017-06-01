function a = on(x,y,opt1,opt2,opt3)

if(exist('opt1')==0)
	strcat('on(',int2str(x),',',int2str(y),');')
elseif( exist('opt2')==0 )
if(isa(opt1,'char'))
	if(opt1=='g')
		opt1 =   strcat('''g''');
	elseif(opt1=='r')
	opt1 =   strcat('''r''');
	elseif(opt1=='b')
	opt1 =  strcat('''b''');
	end
	strcat('on(',int2str(x),',',int2str(y),',',opt1,');')
	else 
		strcat('on(',int2str(x),',',int2str(y),',',int2str(opt1),');')
	end
	elseif(exist('opt3')==0)
	if(isa(opt1,'char'))
		if(opt1=='g')
			opt1 =   strcat('''g''');
		elseif(opt1=='r')
		opt1 =   strcat('''r''');
		elseif(opt1=='b')
		opt1 =  strcat('''b''');
		else
			opt1='-1';

		end
		opt2 = int2str(opt2);
		end
		strcat('on(',int2str(x),',',int2str(y),',',opt1,',',opt2,');')
		elseif(exist('opt3')==1)
		if(opt1=='g')
			opt1 =   strcat('''g''');
		elseif(opt1=='r')
		opt1 =   strcat('''r''');
		elseif(opt1=='b')
		opt1 =  strcat('''b''');
		end
		if(isa(opt2,'char'))
			opt2='-1';
		else
			opt2=int2str(opt2);
		end
		opt3 = int2str(opt3);
		strcat('on(',int2str(x),',',int2str(y),',',opt1,',',opt2,',',opt3,');')
		end
		end


		function a = off(x,y,opt1)

if(exist('opt1')==0)
             strcat('off(',int2str(x),',',int2str(y),');')
 else
 strcat('off(',int2str(x),',',int2str(y),',',int2str(opt1),');')
end
end



