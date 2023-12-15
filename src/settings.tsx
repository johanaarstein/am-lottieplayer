import { render } from '@wordpress/element';
import Settings from '@components/admin/Settings';

const App = () => <Settings />,
	htmlElement = document.getElementById( 'am-lottieplayer-settings' );

if ( htmlElement ) {
	render( <App />, htmlElement );
}
