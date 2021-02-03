<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name : 'AutoLogout',
        data : function(){
            return {
                events : ['click' , 'mousemove' , 'mousedown' , 'scroll' , 'keypress' , 'load'],

            }
        },
          
    }
</script>
