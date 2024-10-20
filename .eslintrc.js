module.exports = {
	env: {
		browser: true,
		es6: true,
		node: true,
	},
	extends: [
		'eslint:recommended',
		'plugin:@typescript-eslint/recommended',
		'plugin:@typescript-eslint/recommended-requiring-type-checking',
		'plugin:@wordpress/eslint-plugin/recommended',
	],
	globals: {
		JSX: true,
		NodeJS: true,
	},
	ignorePatterns: [ '**/build', '*.config.*', '*.min.*' ],
	parser: '@typescript-eslint/parser',
	parserOptions: {
		ecmaVersion: 2021,
		project: [ './tsconfig.json' ],
		sourceType: 'module',
		tsconfigRootDir: './',
	},
	plugins: [
		'perfectionist',
		'react',
		'react-hooks',
		'@typescript-eslint',
		'import',
	],
	rules: {
		'@typescript-eslint/no-namespace': 'off',
		'@typescript-eslint/no-unused-vars': [
			'warn',
			{
				argsIgnorePattern: '^_',
				caughtErrorsIgnorePattern: '^_',
				varsIgnorePattern: '^_',
			},
		],
		'max-depth': [ 'error', 4 ],
		'no-console': [
			'warn',
			{
				allow: [ 'error', 'warn', 'info' ],
			},
		],
		'perfectionist/sort-imports': 'warn',
		'perfectionist/sort-interfaces': 'warn',
		'perfectionist/sort-jsx-props': 'warn',
		'perfectionist/sort-objects': 'warn',
	},
	settings: {
		'import/resolver': {
			typescript: {},
		},
	},
};
