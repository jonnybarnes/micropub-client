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
            <input type="checkbox" id="location" v-model="showLocation">
        </div>
        <div v-show="showLocation">
            <div v-if="position">
                <p><code>{{ position.coords.latitude }},{{ position.coords.longitude }}</code> (accuracy: {{ position.coords.accuracy }})</p>
            </div>
            <p v-else>Getting your position</p>
            <div id="map" v-show="position"></div>
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
            addMap(latitude, longitude, accuracy) {
                mapboxgl.accessToken = 'pk.eyJ1Ijoiam9ubnliYXJuZXMiLCJhIjoiY2pjeXpndml6NGRobjJ3bjA2Mjg2NGJnNyJ9.UoViVx1c1JcC2Bs2UlExlA';
                let map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v9',
                    center: [longitude, latitude],
                    zoom: 15
                });
                let geoJSON = {
                    type: 'FeatureCollection',
                    features: [{
                        type: 'Feature',
                        geometry: {
                            type: 'Point',
                            coordinates: [longitude, latitude]
                        },
                        properties: {
                            title: 'Mapbox',
                            description: 'Washington, D.C.'
                        }
                    }]
                };
                geoJSON.features.forEach(function (marker) {
                    let el = document.createElement('div');
                    el.className = 'marker'
                    new mapboxgl.Marker(el)
                        .setLngLat(marker.geometry.coordinates)
                        .addTo(map);
                });
            },
            getLocation() {
                // we want to show our position
                // do we need to get it?
                if (this.position == false) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.position = position;
                        },
                        (error) => {
                            console.warn(`[geolocation] ERROR(${error.code}): ${error.message}`);
                        },
                        {enableHighAccuracy: true, timeout: 5000, maximumAge: 0}
                    );
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
            showLocation: function () {
                if (this.showLocation == true) {
                    this.getLocation();
                }
            },
            position: function () {
                this.addMap(
                    this.position.coords.latitude,
                    this.position.coords.longitude,
                    this.position.coords.accuracy
                );
            }
        }
    }
</script>
<style>
    #map {
        height: 200px;
    }
    .marker {
        background-image: url(data:image/png;base64,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);
        background-size: cover;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>
