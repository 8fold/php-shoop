import UIKit

class Human {
    var eyeColor = "Green"
}

class Josh: Human {
    override var myEyeColor = "Hazel"
}

let josh = Josh();

print(josh.myEyeColor);
