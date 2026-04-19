!/bin/bash
 
# API URL无参数时：
URL="http://localhost:9200/api/v1/tunnels"
# API URL有参数时：
# id=119
# URL="http://example.com/api/data?id="+${id}
authorization="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjE0NjUzMjYsImlhdCI6MTc2MTI5MjUyNiwiVXNlcklEIjowLCJVc2VybmFtZSI6IiIsIkVtYWlsIjoibGFuZ25hbmcuY2hlbkBvdXRsb2suY29tIiwiQXBpU2VydmljZVRva2VuIjoiZXlKaGJHY2lPaUpJVXpJMU5pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmxlSEFpT2pFM05qRTBOalV6TWpnc0ltbGhkQ0k2TVRjMk1USTVNalV5T0N3aVZYTmxja2xFSWpvME1ERTBOamdzSWxWelpYSnVZVzFsSWpvaWJHRnVaMjVoYm1jaUxDSkZiV0ZwYkNJNklteGhibWR1WVc1bkxtTm9aVzVBYjNWMGJHOXJMbU52YlNKOS5zdWpKLUJjZkU4c01vbmNBUnNFbkV0WUNfNWptSk8tOS1WTzVJVWVCS1N3In0.LuqrC_sWiO3yD84MvUpbyGyr6jb2rolnNjkLO2LrpFo"
# 发送GET请求并存储响应
response=$(curl -H "Content-Type: application/json" -H "authorization: $authorization" -s $URL )
# 输出响应
echo $response

for channel in $(echo $response | jq ".[] | to_entries | .[]"); do
    echo "1: " $channel
    # echo $($channel |  yq ".id");
done
 
