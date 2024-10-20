import Widget from '@/components/Widget';
import { createRoot } from '@wordpress/element';

const App = () => <Widget />,
	htmlElement = document.getElementById( 'am-lottieplayer-widget' );
if ( ! htmlElement ) {
	throw new Error( 'Missing root element' );
}

const root = createRoot( htmlElement );

root.render( <App /> );
