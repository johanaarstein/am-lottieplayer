import { createRoot } from '@wordpress/element';
import Widget from '@components/Widget';

const App = () => <Widget />,
	htmlElement = document.getElementById( 'am-lottieplayer-widget' );
if ( ! htmlElement ) {
	throw new Error( 'Missing root element' );
}

const root = createRoot( htmlElement );

root.render( <App /> );
