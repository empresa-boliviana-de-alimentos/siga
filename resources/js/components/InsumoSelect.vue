<template>
<div>
    <label class="typo__label">Select with search</label>
    <multiselect v-model="value" :options="options" :custom-label="nameWithLang" placeholder="Select one" label="name" track-by="name"></multiselect>
</div>
</template>

<script>
    export default
    {
        data:()=>({
            value: { name: 'Vue.js', language: 'JavaScript' },
            options: [
            { name: 'Vue.js', language: 'JavaScript' },
            { name: 'Rails', language: 'Ruby' },
            { name: 'Sinatra', language: 'Ruby' },
            { name: 'Laravel', language: 'PHP' },
            { name: 'Phoenix', language: 'Elixir' }
            ]
        }),
        mounted() {
            console.log('select Component')
        }
    }
</script>
