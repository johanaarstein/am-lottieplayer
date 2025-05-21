import { createRoot } from '@wordpress/element'

import Widget from '@/components/Widget'

const htmlElement = document.getElementById( 'am-lottieplayer-widget' )

if ( ! htmlElement ) {
  throw new Error( 'Missing root element' )
}

createRoot(htmlElement).render(<Widget /> )
