<template>
    <div>
        <table>
            <caption>User settings</caption>
            <tbody>
                <tr>
                    <th>me</th>
                    <td>{{ userData.me }}</td>
                </tr>
                <tr>
                    <th>token</th>
                    <td>{{ userData.token }}</td>
                </tr>
                <tr>
                    <th>Scope</th>
                    <td>{{ userData.scope }}</td>
                </tr>
                <tr>
                    <th>Method</th>
                    <td>{{ userData.method }}</td>
                <tr>
                    <th>Micropub Endpoint</th>
                    <td>{{ userData.micropub_endpoint }}</td>
                </tr>
                <tr>
                    <th>Media Endpoint</th>
                    <td>{{ userData.media_endpoint }}</td>
                <tr>
                <tr>
                    <th>Syndication Targets</th>
                    <td><pre>{{ userData.syndication_targets }}</pre></td>
                </tr>
            </tbody>
        </table>
        <p>We can query the micropub endpoint to check what, if any, the media endpoint and syndication targets are.</p>
        <button type="button" v-on:click="queryEndpoint">Query Endpoint</button>
    </div>
</template>
<script>
    module.exports = {
        props: {
            user: {
                type: Object,
                required: true,
            }
        },
        data: function () {
            return {
                userData: this.user,
            }
        },
        methods: {
            queryEndpoint: function () {
                axios.get('/dashboard/settings/query', {
                    'withCredentials': true
                }).then((response) => {
                    this.userData.media_endpoint = response.data.media_endpoint;
                    this.userData.syndication_targets = response.data.syndication_targets;
                }).catch(error => {
                    console.error(error);
                });
            }
        }
    }
</script>