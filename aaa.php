<?php

$json_value = '[[0.684700,0.661400,0.707100,0.637400,0.530300,0.718100,0.572800,0.649500,0.780600,0.728900,0.586300,0.649500,0.661400,0.572800,0.661400,0.750000,0.760300,0.649500,0.559000,0.515400],[-1.000000,0.586300,0.599500,0.484100,0.467700,-1.000000,0.414600,0.572800,0.625000,0.559000,0.467700,0.450700,0.530300,0.500000,0.572800,0.612400,0.661400,0.544900,0.450700,-1.000000],[-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,0.395300,-1.000000,-1.000000],[-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000]]';

$json = '[[17,19,17,29,15,17,16,1,1,0,28,29,29,7,11,2,3,3,30,30],[-1,17,19,17,29,-1,15,15,0,28,9,9,13,13,7,11,2,24,24,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,2,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]';

$aa = json_decode($json, 1); //4*20的数组
$vv = json_decode($json_value, 1);
$a = array(); //20*4的数组
$v = array(); //20*4的数组

//转成20*4的数组
for ($i=0; $i<20; $i++) {

	foreach ($aa as $key => $value) {
		
		$a[$i][] = $value[$i];
	}
	
	foreach ($vv as $key1 => $value1) {
		
		$v[$i][] = $value1[$i];
	}	
}


//用来装结果的数组
$r = array();

$flag = false;

//遍历
for ($i=0; $i<20; $i++) {

	//$tmp_1:  		当前优先
	//$tmp_2:  		下一位优先	
	//$tmp_0:  		当前单个		
	
	unset($tmp_0);
	unset($tmp_1);
	unset($tmp_2);
	
	for ($j = 0; $j < 3; $j++) {
	
		/*
		if ($i == 2 && $a[$i][$j] == 17) {
			
			$a[$i][$j] = -1;
			$v[$i][$j] = -1;
		}
		*/
	
		if ($a[$i][$j] != -1 && $i < 19 && ($key = array_search($a[$i][$j], $a[$i + 1])) !== false) {

			//if ($j > $key) {
			if ($v[$i][$j] < $v[$i+1][$key]) {
				
				//echo "(升)";
				//array_push($tmp, $a[$i][$j] . "(下一位优先)");
				
				if (!isset($tmp_2)) {
					
					$tmp_2 = $a[$i][$j];
					
					if ($i > 0 && $i < 17 && 
					array_search($tmp_2, $a[$i - 1]) !== false &&
					array_search($tmp_2, $a[$i + 1]) !== false &&
					array_search($tmp_2, $a[$i + 2]) !== false && 
					$r[$i] == $tmp_2) {
						
						unset($tmp_2);
					}
				}
			
			//} else if ($j < $key) {
			} else if ($v[$i][$j] > $v[$i+1][$key]) {
				
				//echo "(降)";
				//array_unshift($tmp, $a[$i][$j] . "(当前优先)");
				
				if (!isset($tmp_1)) {
					
					$tmp_1 = $a[$i][$j];
				}
			
			//} else if ($j == $key) {
			} else if ($v[$i][$j] == $v[$i+1][$key]) {
				
				if (!isset($tmp_2) && $r[$i] != $a[$i][$j]) {
									
					$tmp_2 = $a[$i][$j];
				}
				
				//echo "(平)";
				//array_unshift($tmp, $a[$i][$j] . "(看情况)");
				
				/*
				if (isset($tmp_1)) {
				
					$tmp_2 = $a[$i][$j];	
				
				} else {
					
					$tmp_1 = $a[$i][$j];
				}*/

				
				/*
				if ($v[$i][$j] <= $v[$i][$key]) {
					
					if (!isset($tmp_1))
						$tmp_1 = $a[$i][$j];
					
				} else {
					
					if (!isset($tmp_2))
						$tmp_2 = $a[$i][$j];
				}
				*/
				
			}
		
		} else if ($a[$i][$j] != -1) {
			
			//echo "(降)";
			//array_unshift($tmp, $a[$i][$j] . "(当前优先)");
			
			if (!isset($tmp_0) && $i > 0) {
			//if (!isset($tmp_0) && ) {
				
				if (array_search($a[$i][$j], $a[$i - 1]) === false && $j < 2) {
					
					$tmp_0 = $a[$i][$j];
					
				} else if (array_search($a[$i][$j], $a[$i - 1]) !== false && $r[$i-1] != $a[$i][$j] && $j < 2) {
					
					$tmp_0 = $a[$i][$j];
				}
			}
		}
	}
	
	if ($i == 14) {
		
		echo $tmp_1 . " : 1\n";
		echo $tmp_2 . " : 2\n";
		echo $tmp_0 . " : 0\n";
	}
	
	
	if (isset($tmp_1) && !isset($tmp_2) && isset($r[$i])) {
		
		$r[$i+1] = $tmp_1;
		unset($tmp_1);
	}	
	
	if (isset($tmp_1) && !isset($r[$i])) {
		
		$r[$i] = $tmp_1;
		unset($tmp_1);
	}
	
	if (isset($tmp_0) && !isset($r[$i])) {
		
		$r[$i] = $tmp_0;
		unset($tmp_0);
	}

	if (isset($tmp_2) && !isset($r[$i])) {
		
		$r[$i] = $tmp_2;
		unset($tmp_2);
	}
		
	if (!isset($r[$i])) {
		
		$r[$i] = $r[$i][0];
	}
	
	if (isset($tmp_2) && !isset($r[$i+1])) {
		
		$r[$i+1] = $tmp_2;
		unset($tmp_2);
	}

	/*
	if (isset($tmp[0]) && !isset($r[$i])) {
		
		$r[$i] = $tmp[0];
	}
	
	if (isset($tmp[1]) && !isset($r[$i+1])) {
			
		$r[$i+1] = $tmp[1];
	}
	
	if (!isset($r[$i])) {
			
		$r[$i] = 0;
	}
	
	echo $i . ":\n";
	print_r($tmp);
	*/
	
	
}


ksort($r);

print_r($r);

foreach ($r as $item) {
	
	printf("%02d-", $item);
}



/*

[17,17,25,17,29,29,29, 5, 5,31,29, 5, 0,27,13,28,12,29,29,16],
[-1,-1,19,25,17,30,30,29,15,15,31,29, 5, 0,28,15,-1,12,16,29],
[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,15,-1,-1],
[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]



正确的:
25, 17, 29, 30, 29, 5, 15, 31, 29, 5, 0, 27, 13, 28, 15, 12, 29, 16,
算出来的：
25, 17, 29, 30, 30, 5, 15, 15, 15, 15, 15, 15, 28, 28, 28, 29, 16, 16




*/




    #include <stdio.h>
    
    float data[32*20] = {0.0,0.0,0.0,0.0,0.0,0.433,0.7806,0.3536,0.1768,0.4507,0.3062,0.0,0.0,0.25,0.2165,0.0,0.2165,0.0,0.0,0.0,0.2165,0.0,0.0,0.0,0.0,0.433,0.4841,0.0,0.375,0.7395,0.8197,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.2165,0.0,0.0,0.0,0.0,0.375,0.0,0.0,0.696,0.8004,0.5303,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.25,0.3062,0.2795,0.4146,0.4146,0.2165,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.3307,0.0,0.3307,0.3307,0.125,0.0,0.1768,0.0,0.0,0.0,0.0,0.0,0.2165,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.3062,0.25,0.125,0.25,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.2165,0.0,0.0,0.0,0.0,0.0,0.5,0.7289,0.3062,0.2165,0.0,0.1768,0.25,0.1768,0.0,0.0,0.2795,0.0,0.7289,0.7395,0.1768,0.3307,0.0,0.0,0.0,0.0,0.25,0.0,0.0,0.0,0.0,0.5728,0.5863,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.25,0.2165,0.1768,0.0,0.2165,0.3307,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.2795,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.1768,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.125,0.0,0.0,0.1768,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.1768,0.0,0.0,0.0,0.0,0.0,0.6374,0.6614,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.625,0.5863,0.0,0.0,0.0,0.0,0.125,0.1768,0.0,0.0,0.1768,0.0,0.0,0.0,0.0,0.0,0.75,0.6847,0.0,0.0,0.0,0.2795,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.7603,0.7181,0.2165,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.6124,0.7706,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.7181,0.6731,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.2165,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.5,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.625,0.4146,0.5728,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.6374,0.6374,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.6731,0.5863,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.696,0.6847,0.7071,0.6614,0.0,0.0,0.0};
    
    int array_search(int num, int a[], int array_length) {
        
        if (array_length <= 0 || a == NULL) {
            return -2; // 数据异常
        }
        
        for (int i=0; i<array_length; i++) {
            
            if (num == a[i]) {
                return i;
            }
        }
        
        return -1; // 没找到
    }
    
    int isset(int num) {
        
        if (num != -1) {
            return 1;
        }else {
            return 0;
        }
    }
    
    void unset(int *num) {
        
        if (num != NULL) {
            *num = -1;
        }
    }
    
    int main(int argc, char *argv[]) {
        
        float dataa[20][32] = {0};
        
        for (int j=0; j<32; j++) {
            for (int i=0; i<20; i++) {
                dataa[i][j] = data[j*20 + i];
            }
        }
        
        int sortData[20][4];
        float sortValue[20][4];
        
        for (int i=0; i<4; i++) {
            for (int j=0; j<20; j++) {
                sortData[j][i] = -1;
                sortValue[j][i] = -1;
            }
        }
        
        for (int i=0; i<20; i++) {
            for (int k=0; k<4; k++) {
                
                int tmp = -1;
                float tmpData = 0;
                int aa = 0;
                
                for (int j=0; j<32; j++) {
                    
                    if (dataa[i][j] > tmpData && dataa[i][j] != 0) {
                        tmp = j;
                        tmpData = dataa[i][j];
                        aa = 1;
                    }
                }
                
                if	(aa == 1) {
                    
                    sortValue[i][k] = dataa[i][tmp];
                    dataa[i][tmp] = 0;
                    sortData[i][k] = tmp;
                    aa = 0;
                }
            }
        }
        
        
        int resultArray[20] = {-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1};
        
        printf("   ");
        for (int i=0; i<20; i++) {
            
            int tmp[3] = {-1,-1,-1};
            
            for (int j=0; j<3; j++) {
                
                int key = -1;
                
                if (sortData[i][j] != -1 && i<19 && (key = array_search(sortData[i][j], sortData[i+1], 4)) >= 0) {
                    
                    if (sortValue[i][j] < sortValue[i+1][key]) {
                        
                        if (!isset(tmp[2])) {
                            
                            tmp[2] = sortData[i][j];
                            
                            if (i > 0 && i < 17 &&
                                array_search(tmp[2], sortData[i - 1], 4) >= 0 &&
                                array_search(tmp[2], sortData[i + 1], 4) >= 0 &&
                                array_search(tmp[2], sortData[i + 2], 4) >= 0 &&
                                resultArray[i] == tmp[2]) {
                                
                                unset(&tmp[2]);
                            }
                        }
                        
                    }else if (sortValue[i][j] > sortValue[i+1][key]) {
                        
                        if (!isset(tmp[1])) {
                            
                            tmp[1] = sortData[i][j];
                        }
                        
                    }else if (sortValue[i][j] == sortValue[i+1][key]) {
                        
                        if (!isset(tmp[2]) && resultArray[i] != sortData[i][j]) {
                            
                            tmp[2] = sortData[i][j];
                        }
                    }
                    
                }else if (sortData[i][j] != -1) {
                    
                    if (!isset(tmp[0]) && i > 0) {
                        
                        if (array_search(sortData[i][j], sortData[i-1], 4) == -1 && j < 2) {
                            
                            tmp[0] = sortData[i][j];
                            
                        }else if (array_search(sortData[i][j], sortData[i-1], 4) >= 0 && resultArray[i-1] != sortData[i][j] && j < 2) {
                            
                            tmp[0] = sortData[i][j];
                        }
                    }
                }
            }
            
            if (isset(tmp[1]) && !isset(tmp[2]) && isset(resultArray[i])) {
                
                resultArray[i+1] = tmp[1];
                unset(&tmp[1]);
            }
            
            if (isset(tmp[1]) && !isset(resultArray[i])) {
                
                resultArray[i] = tmp[1];
                unset(&tmp[1]);
            }
            
            if (isset(tmp[0]) && !isset(resultArray[i])) {
                
                resultArray[i] = tmp[0];
                unset(&tmp[0]);
            }
            
            if (isset(tmp[2]) && !isset(resultArray[i])) {
                
                resultArray[i] = tmp[2];
                unset(&tmp[2]);
            }
			
            if (!isset(resultArray[i])) {
                
                resultArray[i] = sortData[i][0];
                
                if (resultArray[i] == -1) {
                    
                    resultArray[i] = 0;
                }
            }
            
            
            if (isset(tmp[2]) && !isset(resultArray[i+1])) {
                
                resultArray[i+1] = tmp[2];
                unset(&tmp[2]);
            }
            
            printf("%2d ", resultArray[i]);
        }
        
        printf("\n\n");
        
        // print
        /*
         for (int j=31; j>=0; j--) {
         
         printf("%2d: ",j);
         for (int i=0; i<20; i++) {
         printf("%.4f ", dataa[i][j]);
         }
         printf("\n");
         }
         */
        
        for (int i=0; i<4; i++) {
            
            printf("%d: ", i);
            for (int j=0; j<20; j++) {
                if (sortData[j][i] != -1) {
                    printf("%2d ", sortData[j][i]);
                }else {
                    printf("   ");
                }
            }
            printf("\n");
        }
        printf("\n");
        
        for (int i=0; i<4; i++) {
			
			printf("%d: ", i);
			for (int j=0; j<20; j++) {
				if (sortValue[j][i] != -1) {
					printf("%.4f  ", sortValue[j][i]);
				}else {
					printf("        ");
				}
			}
			printf("\n");
		}
		printf("\n");
    }
    
    /*
     17-19-29-22-16-00-00-06-18-02-01-15-07-27-31-17-31-26-26-06-
     17 19 29 22 16  0  0  6 18  2  1 15  7  6 31 17 31 26 26  6 
     17-19-29-22-16-00-00-06-18-02-01-15-07-27-31-17-31-26-26-06-
     
     0: 17 19 19 29 16 16  0  6 18  2  1 15 27 31 17 17 31 26  6  6 
     1:  1 17 29 22 12  0  6 18  2  1 15  7  7 27 31 31 26    26    
     2:  2  7       15  1  1  0  3  0  2  8  6  0  0 10  8     4    
     3:  6 20           2  4  3  1  3  0  6  8  6 16  8  6     2 
     
     
     17 19
     19 29
     29 22
     29 16
     16  0
     0  1
     0  6
     
     
     
     
     
     
     
     
     [[17,19,19,29,16,16,0, 6,18,2, 1,15,27,31,17,17,31,26,6,6],
     [  1,17,29,22,12, 0,6,18, 2,1,15, 7, 7,27,31,31,26,-1,26,-1],
     [  2, 7,-1,-1,15, 1,1, 0, 3,0, 2, 8, 6, 0, 0,10,8,-1,4,-1],
     [  6,20,-1,-1,-1, 2,4, 3, 1,3, 0, 6, 8, 6,16,8,6,-1,2,-1]]';
     
     
     
     0: 0.7500  0.7181  0.6731  0.5863  0.6250  0.5863  0.7806  0.7289  0.7706  0.8004  0.8197  0.6614  0.6374  0.6960  0.7603  0.7181  0.6614  0.4146  0.7289  0.7395  
     1: 0.2165  0.6847  0.6731  0.5000  0.1768  0.4330  0.5000  0.6124  0.6960  0.7395  0.6374  0.5728  0.5863  0.6374  0.6847  0.7071  0.6250          0.5728          
     2: 0.2165  0.3307                  0.1768  0.4330  0.4841  0.3536  0.4146  0.4507  0.5303  0.2500  0.2500  0.2500  0.2165  0.2795  0.3307          0.2165          
     3: 0.2165  0.2165                          0.3750  0.3307  0.2795  0.3750  0.4146  0.3062  0.1768  0.2165  0.1768  0.1768  0.2165  0.2795          0.1250  
     
     
     0: 0.7500  0.7181  0.6731  0.5863  0.6250  0.5863  0.7806  0.7289  0.7706  0.8004  0.8197  0.6614  0.6374  0.6960  0.7603  0.7181  0.6614  0.4146  0.7289  0.7395  
     1: 0.2165  0.6847  0.6731  0.5000  0.1768  0.4330  0.5000  0.6124  0.6960  0.7395  0.6374  0.5728  0.5863  0.6374  0.6847  0.7071  0.6250          0.5728          
     2: 0.2165  0.3307                  0.1768  0.4330  0.4841  0.3536  0.4146  0.4507  0.5303  0.2500  0.2500  0.2500  0.2165  0.2795  0.3307          0.2165          
     3: 0.2165  0.2165                          0.3750  0.3307  0.2795  0.3750  0.4146  0.3062  0.1768  0.2165  0.1768  0.1768  0.2165  0.2795          0.1250          
     
     
     
     
     
     
    */