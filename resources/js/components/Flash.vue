<template>
    <div class="container">
        <div class="card-body">
            <div class="card-header">
                <div class="alert alert-success alert-flash" role="alert" v-show="show">
                    <strong>Success!</strong> {{ body }}
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['message'],
        data() {
            {
                return {
                    body: '',
                    show: false
                }
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message);
            }
            window.events.$on(
                'flash', message => this.flash(message)
            );
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
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
