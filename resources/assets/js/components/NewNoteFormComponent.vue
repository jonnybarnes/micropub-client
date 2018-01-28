<template>
    <form :action="action" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <div v-if="showReply">
            <label for="reply">Reply To:</label>
            <input name="reply" id="reply">
        </div>
        <button type="button" v-if="showReply == false" v-on:click="showReply = !showReply">Reply</button>
        <div>
            <label for="note">Note:</label>
            <textarea name="note" id="note"></textarea>
        </div>
        <div v-if="targets">
            <fieldset>
                <legend>Syndication</legend>
                <template v-for="target in targets">
                    <label :for="target.uid">{{ target.name }}:</label>
                    <input :id="target.uid" name="mp-syndicate-to[]" type="checkbox" :value="target.uid">
                </template>
            </fieldset>
        </div>
        <div v-if="mediaurls.length > 0">
            <div v-for="media in mediaurls">
                <label :for="media"><img :src="media"></label>
                <input type="checkbox" selected="selected" :value="media" :id="media">
            </div>
        </div>
        <div v-if="mediaEndpoint">
            <label for="files">Media:</label>
            <input type="file" id="files" ref="files" multiple v-on:change="handleFileUploads()">
            <button type="button" v-on:click="submitFiles()">Upload Media</button>
        </div>
        <div>
            <label for="location">Location:</label>
            <input type="checkbox" :checked="showLocation" id="location" v-on:change="getLocation">
        </div>
        <div v-if="showLocation">
            <div v-if="position">
                <p><code>{{ position.coords.latitude }},{{ position.coords.longitude }}</code> (accuracy: {{ position.coords.accuracy }})</p>
            </div>
            <p v-else>Getting your position</p>
            <div id="map"></div>
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</template>
<script>
    module.exports = {
        props: {
            action: {
                type: String,
                required: true,
            },
            csrf: {
                type: String,
                required: true,
            },
            mediaEndpoint: {
                type: String,
                required: false,
            },
            targets: {
                validator: function (value) {
                    return value[0].hasOwnProperty('uid')
                        && value[0].hasOwnProperty('name');
                },
                required: false,
            },
            token: {
                type: String,
                required: false,
            }
        },
        data: function () {
            return {
                files: '',
                mediaurls: [],
                position: false,
                showLocation: false,
                showReply: false,
            }
        },
        methods: {
            addMap(latitude, longitude) {
                mapboxgl.accessToken = 'pk.eyJ1Ijoiam9ubnliYXJuZXMiLCJhIjoiY2pjeXpndml6NGRobjJ3bjA2Mjg2NGJnNyJ9.UoViVx1c1JcC2Bs2UlExlA';
                let map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v9',
                    center: [longitude, latitude],
                    zoom: 4
                });
            },
            getLocation() {
                // first topggle showLocation, which is associated
                // with the checkbox
                this.showLocation = !this.showLocation;
                // now, if we want to show the location, lets save it
                if (this.showLocation == true) {
                    // we want to show our position
                    // do we need to get it?
                    if (this.position == false) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                console.log(position);
                                this.position = position;
                            },
                            (error) => {
                                console.warn(`[geolocation] ERROR(${error.code}): ${error.message}`);
                            },
                            {enableHighAccuracy: true, timeout: 5000, maximumAge: 0}
                        );
                    }
                }
            },
            handleFileUploads() {
                this.files = this.$refs.files.files;
            },
            submitFiles() {
                for (let file of this.files) {
                    let formData = new FormData();
                    formData.append('file', file);
                    axios.post(
                        this.mediaEndpoint,
                        formData,
                        {
                            headers: {
                                'Authorization': 'Bearer ' + this.token,
                                'Content-Type': 'multipart/form-data',
                            }
                        }
                    ).then(response => {
                        // we put a timeout to allow for any image processing
                        // that might take place
                        setTimeout(() => {
                            this.mediaurls.push(response.data.location)
                        }, 2000);
                    }).catch(response => {
                        console.error(response);
                    });
                }
            }
        },
        watch: {
            position: function () {
                if (this.showLocation == true) {
                    this.addMap(this.position.coords.latitude, this.position.coords.longitude);
                }
            }
        }
    }
</script>
<style>
    #map {
        height: 200px;
    }
</style>
