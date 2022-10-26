import {cacher} from "../includes/cacher"
import {describe ,it ,expect} from "vitest"

describe("Test cacher",()=>{
    it("initialies without error",()=>{
        expect(cacher.init()).toBe(true)
    })
})