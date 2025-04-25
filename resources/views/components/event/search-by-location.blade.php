<script>
  google.maps.importLibrary("places");
</script>
<div x-data="{ search: '', options: [], showOptions: false,
    toast(text, background)
    {
        Toastify({
            text: text, 
            style: {
            background: background,
            color: '#fff'
            }
        }).showToast();
    },
    async searchByLocation()
    {
        if(this.search.length > 2){
            this.showOptions = true;
            const { Place } = await google.maps.importLibrary('places');
            const request = {
                textQuery: this.search,
                fields: ['displayName', 'location', 'businessStatus', 'id'],
                locationBias: { lat: 9.0820, lng: 8.6753 },
                isOpenNow: true,
                language: 'en-US',
                maxResultCount: 8,
                minRating: 3.2,
                region: 'ng'
            };
            const { places } = await Place.searchByText(request);
    
            this.options = places.map(place => { 
                return {
                    displayName: place.displayName,
                    lat: place.Eg.location.lat,
                    long: place.Eg.location.lng,
                    businessStatus: place.businessStatus,
                    id: place.id,
                };
            });
        }
        
    },
    searchdatabaseForOption(option)
    {
        $store.place.details = option;
        $dispatch('new-place-chosen')
    },
    async myLocation()
    {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    let address = this.ReverseGeocodingUsingLatnLong(position.coords.latitude, position.coords.longitude).then( result => {
                        this.search = result.formatted_address
                        $store.place.details = {
                            address: result.formatted_address,
                            lat: position.coords.latitude,
                            long: position.coords.longitude,
                            id: result.place_id                    
                        }
                        $dispatch('new-place-chosen')
                        this.showOptions = false;
                    });
                }),
                ()=> {
                    this.toast('Unable to retrieve your location. Please check your browser settings.', 'red');
                }
        } else {
            this.toast('Geolocation is not supported by this browser.', 'red');
        }
    },
    async ReverseGeocodingUsingLatnLong(lat, lng) {
        await google.maps.importLibrary('geocoding');
        const geocoder = new google.maps.Geocoder();

        const latlng = new google.maps.LatLng(lat, lng);

        try {
            const response = await geocoder.geocode({ location: latlng });
            
            if (response.results && response.results.length > 0) {
                return response.results[0]; // or return the whole response if you want more
            } else {
                this.toast('No results found', 'blue');
                return null;
            }
        } catch (error) {
            console.error('Geocoding failed:', error);
            this.toast('Unable to retrieve location details.', 'red');
            return null;
        }
    }
 }" class="relative w-full">
    <input 
        type="search"   
        x-model="search" 
        @focus="showOptions = true"
        @blur="showOptions = false"
        placeholder="Search..." 
        class="border-0 border-b-2 border-gray-600 p-2 bg-transparent focus:outline-0 focus:ring-0 ring-0 outline-0 w-full md:mt-6 text-purple-1000"
        @input.debounce.500ms="searchByLocation"
    />

    <ul x-show="showOptions" 
        class="absolute bg-white border rounded w-full mt-1 shadow-lg z-10"
    >
        <li @mousedown="myLocation(); showOptions = false;" 
            class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-purple-1000"
            >Use my location</li>
        <template x-for="option in options" :key="option.id">
            <li 
            @mousedown="searchdatabaseForOption(option); showOptions = false;search = option.displayName" 
                class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-purple-1000"
            >
                <span x-text="option.displayName"></span>
            </li>
        </template>
    </ul>
</div>
