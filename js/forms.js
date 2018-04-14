//Funçao de mascara para celular
            
            function mascaraCelular(obj){
                var numbers = obj.value.replace(/\D/g,''), char = {0:'(', 2: ') ', 7: '-'};
                obj.value = '';
                for(var i = 0; i < numbers.length; i++){
                    obj.value += (char[i] || '') + numbers[i];
                }
            }