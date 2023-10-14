import defaults from '@wordpress/scripts/config/webpack.config'
import { join, resolve } from 'path'
import { writeFile } from 'fs'
import { sync } from 'glob'

const rename = () => {
	const blockJSONFiles = sync(
		join(process.cwd(), 'build', '**', 'block.json')
	)

	if (blockJSONFiles) {
		blockJSONFiles.forEach(filePath => {
			const blockJSON = require(filePath)

			if (blockJSON?.editorScript) {
				blockJSON.editorScript = blockJSON.editorScript.replace('.tsx', '.js')
			}

			if (blockJSON?.script) {
				blockJSON.script = blockJSON.script.replace('.tsx', '.js')
			}

			if (blockJSON?.viewScript) {
				blockJSON.viewScript = blockJSON.viewScript.replace('.tsx', '.js');
			}

			if (blockJSON?.editorStyle) {
				blockJSON.editorStyle = blockJSON.editorStyle.replace('.scss', '.css');
			}

			if (blockJSON?.style) {
				blockJSON.style = blockJSON.style.replace('.scss', '.css');
			}

			writeFile(filePath, JSON.stringify(blockJSON, null, 2), function writeJSON(error) {
				if (error) return console.log(error)
			})
		})
	}
},

	config = {
		...defaults,
		plugins: [
			...defaults.plugins,
			{
				apply: ({ hooks }) => {
					hooks.afterEmit.tap('rename', rename)
				}
			}
		],
		resolve: {
			...defaults.resolve,
			alias: {
				...defaults.resolve.alias,
				'@assets': resolve(__dirname, '/src/assets'),
				'@components': resolve(__dirname, '/src/components'),
				'@functions': resolve(__dirname, '/src/functions'),
				'@types': resolve(__dirname, '/src/types')
			}
		}
	}

export default config
