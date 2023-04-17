
<template>
    <div class="center">
        <div>
            <input type="text" v-model="name" id="name" placeholder="name">
        </div>
        <div>
            <input type="text" v-model="stage" id="stage" placeholder="stage">
        </div>
        <div>
            <button @click="createDeal()" class="button">submit</button>
        </div>
        <div>
            {{result}}
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            name: '',
            stage: '',
            result: '',

        }
    },
    methods: {

        createDeal () {

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('stage', this.stage);

            const headers = { 
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
             };

            axios.post('api/deals', formData, { headers }).then((res) => {
                this.result = res.data
            }).catch((res) => {
                console.log(res)
                this.result = res.response.data
            })


        }


    },
    mounted() {

    }
}
</script>