<template>
	<div class="dublicat-box">

		<div class="col-md-9 col-sm-12">
			<div class="input-group"  >
				<a href="#" class="input-group-addon" @click.prevent="$emit('delete')">X</a>
				<div class="input-wrapper">
					<input type="text" class="form-control places-input" :placeholder="placeholder" v-model="name">
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-12">
			<div class="input-group">
				<div class="dropdown">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<template v-if="radius">
							Up to {{radius}} km
						</template>
						<template v-else>
							{{levelPlaceholder}}
						</template>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li v-for="r in radiusList"><a href="#" @click.prevent="radiusChanged(r)">Up to {{r}} km</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "LevelSelector",
	data() {
		return {
			checkErrors:false,
			name: '',
			_name: '',
			autocomplete: null,
			radius: '',
			lat: '',
			lng: ''
		}
	},
	props: {
		radiusList: {
			default() {
				return [10,25,50,100];
			}
		},
		levelPlaceholder: {
			default: 'Select radius',
			type: String
		},
		placeholder: {
			default: "Start typing and select",
			type: String
		},
		value: ''
	},
	created() {
		// this.name = this.value[this.displayField];
	},
	mounted() {
		let defaultBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng(-33.8902, 151.1759),
			new google.maps.LatLng(-33.8474, 151.2631));

		let input = $(this.$el).find(".places-input").get(0);
		let options = {
			bounds: defaultBounds,
			types: ['geocode']
		};

		this.autocomplete = new google.maps.places.Autocomplete(input, options);

		this.autocomplete.addListener("place_changed", this.placeChanged);

		if(this.value) {
			this.setValue();
		}

	},
	watch: {
		value(value) {
			this.setValue();
		}
	},
	methods: {

		setValue() {
			this.radius = this.value.radius;
			this.name = this.value.name;
			this._name = this.value.name;
			this.lat = this.value.lat;
			this.lng = this.value.lng;
		},
		placeChanged() {
			this.getSelected();
			this.update();
		},
		radiusChanged(r) {
			this.radius = r;
			this.update();
			// this.placeChanged();
		},
		update() {
			this.$emit("selected", this.getValue());
		},
		getSelected() {
			let place = this.autocomplete.getPlace();

			// console.log(place);
			if(!(place && place.geometry)) {
				return null;
			}

			this._name = place.formatted_address;
			this.name = place.formatted_address;
			this.lat = place.geometry.location.lat();
			this.lng = place.geometry.location.lng();
		},
		getValue() {
			return {
				name: this._name,
				lat: this.lat,
				lng: this.lng,
				radius: this.radius
			}
		}
	}
}
</script>

<style scoped lang="scss">
.input-wrapper {
	float: left;
	width: 100%;

	.select-list {
		position: absolute;
		left: 0;
		top: 0;
		list-style: none;
		margin: 0;
		padding: 0;
		border: 1px solid #F1F1F1;
		border-top: none;
		width: 100%;
		max-height: 200px;
		overflow-y: auto;
		z-index: 10;

		li a {
			display: block;
			padding: 5px;
			background: #FFF;
			border-bottom: 1px solid #F1F1F1;
		}

		li:last-child a {
			border-bottom: none;
		}
	}

}
</style>