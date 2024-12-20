import standard from 'stylelint-config-standard-scss'

/**
 * @type {import('stylelint').Config}
 * */
const config = {
	...standard,
	rules: {
		...standard.rules,
		"no-descending-specificity": [
			true,
			{
				severity: "warning",
			},
		],
		"selector-class-pattern": null,
    "keyframes-name-pattern": null,
    "custom-property-pattern": null,
	},
};

export default config