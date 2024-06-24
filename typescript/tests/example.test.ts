import {exampleFunction} from "../src/example";

describe('example function', () => {
    test('function returns true', () => {
        expect(exampleFunction()).toEqual(true);
    });
});