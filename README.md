# Mars Rover coding challenge

### Description
A squad of robotic rovers is to be landed by NASA on a plateau on Mars.

This plateau, which is curiously rectangular, must be navigated by the rovers so that their onboard cameras can get a 
complete view of the surrounding terrain to send back to Earth. A rover's position is represented by a combination of 
an `x` and `y` coordinates and a letter representing one of the four cardinal compass points. 
The plateau is divided up into a grid to simplify navigation. An example position might be `0, 0, N` which means the 
rover is in the bottom left corner and facing North.

In order to control a rover, NASA sends a simple string of letters. 
The possible letters are `L`, `R` and `M`. `L` and `R` make the rover spin 90 degrees left or right respectively, 
without moving from its current spot.
`M` means move forward one grid point, and maintain the same heading.
Assume that the square directly North from `(x, y)` is `(x, y+1)`.

Input:
The first line of input is the upper-right coordinates of the plateau, the lower-left coordinates are assumed to be 
`0,0`.

The rest of the input is information pertaining to the rovers that have been deployed. 
Each rover has two lines of input. 
The first line gives the rover's position, and the second line is a series of instructions telling the rover how to 
explore the plateau.

The position is made up of two integers and a letter separated by spaces, corresponding to the `x` and `y` coordinates 
and the rover's orientation.
Each rover will be finished sequentially, which means that the second rover won't start to move until the first one has
finished moving.

Output:
The output for each rover should be its final coordinates and heading.
Test input:
`5 5`

`1 2 N`

`LMLMLMLMM`

`3 3 E`

`MMRMMRMRRM`

Test output:
`1 3 N`

`5 1 E`

### Required
The goal is to achieve 100% test coverage and include an integration test that verifies the program’s output matches 
the expected results from the challenge description.
Additionally, a symfony command should be created that will be accepting as an input:
- the plateau dimensions
- the position & direction of each rover
- the instructions to move each rover

### Deliverables

To generate the docker container & run symfony command, please use the following commands:

`docker-compose up --build`

`docker-compose exec php php bin/console.php app:mars-rover "5 5" "1 2 N" "LMLMLMLMM" "3 3 E" "MMRMMRMRRM"`

For phpunit coverage report, please run:

`./vendor/bin/phpunit --coverage-text --coverage-filter=src`

To generate an HTML coverage report, please run the following command, and then navigate to the `coverage-report` 
directory in your project, where you can find an `index.html` that can be accessed via a browser.

`./vendor/bin/phpunit --coverage-html coverage-report --coverage-filter=src`

Lastly, PHPStan and CodeSniffer have been added to the project.

To run PHPStan, please use `vendor/bin/phpstan`.

To run CodeSniffer, please use `vendor/bin/phpcs`