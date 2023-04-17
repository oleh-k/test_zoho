
<template>
    <div class="center">
        <div>
            <button @click="getToken()" class="button">get token</button>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            result: '',

        }
    },
    methods: {

        getToken () {

            let urlBasePath = 'https://accounts.zoho.com/oauth/v2/auth';
            let scope = 'ZohoCRM.modules.ALL';
            let client_id = '1000.D64CQK4BEWB7AX7YIKRSB79FDGN6TP';
            let state = 'testing';
            let response_type = 'code';
            let redirect_uri = 'http://localhost:8000/api/grand_token';
            let access_type = 'offline';

            let url = `${urlBasePath}?scope=${scope}&client_id=${client_id}&state=${state}&response_type=${response_type}&redirect_uri=${redirect_uri}&access_type=${access_type}`;

            window.open(url);

        }


    },
    mounted() {

    }
}
</script>