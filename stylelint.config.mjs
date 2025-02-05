import recommended from 'stylelint-config-recommended'

/**
 * @type {import('stylelint').Config}
 * */
const config = {
	...recommended,
	rules: {
		...recommended.rules,
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