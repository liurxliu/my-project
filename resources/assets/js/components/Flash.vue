<template>
    <div :class="classes" role="alert" v-show="show">
        <strong>{{ body }}</strong>
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: '',
                show: false,
                type: '',
            }
        },

        computed: {
            classes() {
                if(this.type == 'success') {
                    return "alert-success flash-alert";
                } else if (this.type == 'error') {
                    return "alert-danger flash-alert";
                }

            }
        },

        created() {
            if(this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', (data) => {
                this.type = data.type;
                this.flash(data.msg);
            });
        },
        methods: {
            flash(message) {
                this.body = message;
                this.show = true;
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>
<style>
    .flash-alert {
        border-radius: 5px;
        color: white;
        position: fixed;
        right: 25px;
        bottom: 50px;
    }
    .alert-success {
        background-color: green;
        padding: 20px;
    }
    .alert-danger {
        background-color: red;
        padding: 20px;
    }
</style>
