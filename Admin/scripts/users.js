
     
        function get_users() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/users.php", true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('users-data').innerHTML = this.responseText;
                } else {
                    console.error("Failed to fetch data: " + xhr.statusText);
                }
            };

            xhr.onerror = function () {
                console.error("Request failed");
            };

            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('get_users');
        }



 

        function remove_user(user_id) 
        {
            if(confirm("Are you sure you want to remove this user?"))
        {
            let data = new FormData();
            data.append('user_id', user_id);
            data.append('remove_user', '');
        
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/users.php", true);

            xhr.onload = function () {

                if (this.responseText == 1) {
                    showAlert('success', 'User Removed');
                    get_users();
                    
                }

                else {
                    showAlert('error', 'User removal failed!');
                
                }
            }
            xhr.send(data);
        }
        
        }




        window.onload = function () {
            get_users();
        };