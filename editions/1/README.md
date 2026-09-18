# Enigma Mob Programming

## Mob Programming Guidelines
* The Driver controls the keyboard and focuses only on implementing instructions.
* The Driver communicates only with the Navigator.
* The Navigator guides the Driver, translates input from the team.
* The rest of the team forms the Mob. They provide feedback to the driver, and steer the general direction.
* Rotate roles regularly to encourage knowledge sharing and collective ownership.
* **No Ai!**


## Teams
* Team **Green**: Creates the plugboard, keyboard and lampboard (input and output)
* Team **Yellow**: Creates the rotor housing and reflector
* Team **Blue**: Creates the rotors

## Requirements
* Plugboard, reflector, rotor wiring and start positions are configurable through the plugboard
* A full sentence can be encrypted (and decrypted!)
* A UI or visual simulation is not required

## Deployments
The individual components should be exposed using NGROK. 
See ngrok_docker for an example.

## The Enigma Machine

### Plugboard

The plugboard swaps pairs of letters before and after the rotor process.

Example configuration:

```text
AB CD EF GH IJ
```

Meaning:

```text
A ↔ B
C ↔ D
E ↔ F
G ↔ H
I ↔ J
```

All other letters remain unchanged.

---

### Rotor Wiring

Example rotor wirings:

```text
Left Rotor (Rotor III):
BDFHJLCPRTXVZNYEIWGAKMUSQO

Middle Rotor (Rotor II):
AJDKSIRUXBLHWTMCQGZNPYFVOE

Right Rotor (Rotor I):
EKMFLGDQVZNTOWYHXUSPAIBRCJ
```
---

### Rotor Positions

Rotor positions are the visible starting letters shown in the rotor windows.

Example:

```text
K Q F
```

Meaning:

```text
Left Rotor   → K
Middle Rotor → Q
Right Rotor  → F
```

The rotor positions:

- determine the starting rotation of each rotor
- change continuously during encryption
- are visible to the operator

---

### Reflector Configuration

The reflector sends the signal back through the rotors.

Example reflector:

```text
YRUHQSLDPXNGOKMIEBFZCWVJAT
```

Example mappings:

```text
A ↔ Y
B ↔ R
C ↔ U
D ↔ H
...
```

The reflector:

- always maps letters in pairs
- never maps a letter to itself
- makes encryption symmetric

Meaning:

```text
If A encrypts to N,
then N encrypts to A
```

---

### Full Example Configuration

```text
Plugboard:
AB CD EF GH IJ

Rotor wiring:
ekmflgdqvzntowyhxuspaibrcj
ajdksiruxblhwtmcqgznpyfvoe
bdfhjlcprtxvznyeiwgakmusqo

Rotor start Positions:
K Q F

Reflector:
YRUHQSLDPXNGOKMIEBFZCWVJAT
```

This fully defines an Enigma machine state for encryption and decryption.
