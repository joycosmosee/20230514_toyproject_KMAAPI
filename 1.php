<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>60초마다 새로고침</title>
  <h1>실시간 카운터</h1>
  <p id="counter">60</p>
  
  <script>
    setTimeout(function() {
      location.reload();
    }, 60000); // 60초(60,000밀리초) 후에 페이지를 새로고침합니다.
  </script>

<script>
    var counterElement = document.getElementById('counter');
    var count = 60;

    function updateCounter() {
      counterElement.innerText = count;
      count--;

      if (count < 0) {
        count = 60;
      }

      setTimeout(updateCounter, 1000); // 1초마다 updateCounter 함수 호출
    }

    // 페이지가 로드될 때 카운터 시작
    window.onload = function() {
      updateCounter();
    };
  </script>
</head>
<body>
  <h1>PHP 페이지</h1>
  <!-- PHP 코드와 콘텐츠를 이곳에 추가합니다 -->
    <?php
        /* s---------------------------------- 기상청 API 불러와서 txt 만드는 법 */
            // 저장할 파일명과 경로
            $filename = "Kmaapi.txt";
            $filepath = "./" . $filename;

            //URL에서 데이터 가져오기 : 새별오름 : 883
            //URL에서 데이터를 가져오기 위해서는 file_get_contents() 함수를 사용합니다. 이 함수는 URL을 포함한 파일의 전체 내용을 문자열로 반환합니다.
            $url = "https://apihub.kma.go.kr/api/typ01/cgi-bin/url/nph-aws2_min?tm2=&stn=883&disp=0&help=1&authKey=";

            // URL 내용을 가져오기 위해 CURL 사용
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            
            // 가져온 내용을 파일에 저장
            $file = fopen($filepath, "w");
            fwrite($file, $output);
            fclose($file);

            echo "File saved successfully<br><br>";
        /* e---------------------------------- 기상청 API 불러와서 txt 만드는 법 */

        /* s---------------------------------- 파일 불러오기 */
            $isFileChk = "./Kmaapi.txt";

            // echo $isFileChk;

            //is_file() 함수를 사용하여 $isFileChk 변수에 지정된 파일이 존재하는지 확인
            //{ : 1
            if(is_file($isFileChk)){

                // file() 함수를 사용하여 $isFileChk 변수에 지정된 파일을 읽음
                $lines = file("./Kmaapi.txt", FILE_IGNORE_NEW_LINES);
        /* e---------------------------------- 파일 불러오기 */

            /* s---------------------------------- 파일 문자열 공백 제거 */
                $i = 0;
                foreach($lines as $key=>$val){
                    if($key > 21){
                        //explode() 함수를 사용하여 $val 변수에 할당된 문자열을 공백 문자를 기준으로 분리
                        $_data= explode(" ", $val);
                        foreach($_data as $keys=>$vals)		{
                            //trim() 함수를 사용하여 $vals 변수의 양 끝에 있는 공백을 제거
                            //empty() 함수를 사용하여 $vals 변수가 비어있지 않은지 확인
                            if(!empty(trim($vals)))	$_arrData[$i][] = $vals;
                        }
                        $i++;
                    }
                }
                // print_r($_arrData);
            /* e---------------------------------- 파일 문자열 공백 제거 */

            /* s---------------------------------- 배열의 마지막 요소 제거 - 에러 때문에 */
                //$_arrData 배열이 비어 있지 않으면, $_arrData 배열에서 $val 변수를 각각의 요소에 대해 반복
                //$_arrData 배열의 요소 수가 0보다 큰 경우 실행
                //{ : 2
                if(count($_arrData) > 0){
                
                    //배열의 마지막 요소 제거
                    // print_r($_arrData);
                    // array_pop($_arrData);
                    echo "<br>";
                    print_r($_arrData);
                    echo "<br>";
                    $locationName = "새별오름";
                    $STN = (int)$_arrData[0][1];
                    $WD1 = (float)$_arrData[0][2];
                    $WD2 = (float)$_arrData[0][3];
                    // print_r($WD1);
                    // var_dump($locatioName); 
                    // echo "<br>";
                    // var_dump($STN); 
                    // echo "<br>";
                    // var_dump($WD1);
                    // echo "<br>";
                    // var_dump($WD2); 
                    // echo "<br>";


            /* e---------------------------------- 배열의 마지막 요소 제거 - 에러 때문에 */  

                /* s----------------------------------방법1 : DB에 파일 저장 */
                    //MySQL 연결 설정
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "kmaapi";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    var_dump($locationName); 
                    echo "<br>";
                    var_dump($STN); 
                    echo "<br>";
                    var_dump($WD1);
                    echo "<br>";
                    var_dump($WD2); 
                    echo "<br>";

                    // 데이터 삽입 쿼리
                    $sql = "INSERT INTO kmaapi (locationName, STN, WD1, WS1, createAt) VALUES ('$locationName', '$STN', '$WD1', '$WD2', NOW())";

                    if ($conn->query($sql) === TRUE) {
                        echo "데이터가 성공적으로 저장되었습니다.";
                    } else {
                        echo "데이터 저장 실패: " . $conn->error;
                    }
                    
                    // 데이터베이스 연결 종료
                    $conn->close();
                /* e----------------------------------방법1 : DB에 파일 저장 */

        /* s---------------------------------- 파일 불러오기2 끝 */
                //{ : 2
                }
            // { : 1
            }
        /* e---------------------------------- 파일 불러오기2 끝 */
    ?>
</body>
</html>

<temp></temp><temp></temp>
<temp></temp>
<temp></temp>
<temp></temp><temp></temp>
<temp></temp><temp></temp><temp></temp>
