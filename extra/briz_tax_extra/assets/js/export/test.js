const test = {
	fileName: 'Unknown source',

	addEvent( ctx, type ) {
		console.log( ctx, type );
		console.log( 'file name', this.fileName );

		if ( ctx !== document )
			ctx = document.querySelector( ctx )

		ctx.addEventListener( type, this.eventHandler.bind( this ) );
	},

	eventHandler( evt ) {
		console.log( this.fileName, evt.currentTarget );
	},

	init( ctx, type, fromFile ) {
		if ( ctx && type ) this.addEvent( ctx, type );
		if ( fromFile ) this.fileName = fromFile;
	}
};

export { test };
