<?php namespace Celestriode\Captain;

class StringReader implements ImmutableStringReaderInterface
{
    const SYNTAX_ESCAPE = '\\';

    const ALLOWED_QUOTES = [
        '\'' => true,
        '"' => true
    ];

    const ALLOWED_NUMBER = [
        '0' => true,
        '1' => true,
        '2' => true,
        '3' => true,
        '4' => true,
        '5' => true,
        '6' => true,
        '7' => true,
        '8' => true,
        '9' => true,
        '-' => true,
        '.' => true
    ];

    const ALLOWED_IN_QUOTED_STRING = [
        'A' => true,
        'B' => true,
        'C' => true,
        'D' => true,
        'E' => true,
        'F' => true,
        'G' => true,
        'H' => true,
        'I' => true,
        'J' => true,
        'K' => true,
        'L' => true,
        'M' => true,
        'N' => true,
        'O' => true,
        'P' => true,
        'Q' => true,
        'R' => true,
        'S' => true,
        'T' => true,
        'U' => true,
        'V' => true,
        'W' => true,
        'X' => true,
        'Y' => true,
        'Z' => true,
        'a' => true,
        'b' => true,
        'c' => true,
        'd' => true,
        'e' => true,
        'f' => true,
        'g' => true,
        'h' => true,
        'i' => true,
        'j' => true,
        'k' => true,
        'l' => true,
        'm' => true,
        'n' => true,
        'o' => true,
        'p' => true,
        'q' => true,
        'r' => true,
        's' => true,
        't' => true,
        'u' => true,
        'v' => true,
        'w' => true,
        'x' => true,
        'y' => true,
        'z' => true,
        '0' => true,
        '1' => true,
        '2' => true,
        '3' => true,
        '4' => true,
        '5' => true,
        '6' => true,
        '7' => true,
        '8' => true,
        '9' => true,
        '_' => true,
        '-' => true,
        '.' => true,
        '+' => true,
    ];

    /** @var string $string */
    private $string = '';
    private $stringParts = [];

    /** @var int $length */
    private $length = 0;

    /** @var int $cursor */
    private $cursor = 0;

    public function __construct($input)
    {
        if ($input instanceof StringReader) {

            $this->string = $input->string;
            $this->cursor = $input->cursor;
        } else if (is_string($input)) {

            $this->string = $input;
        } else {

            throw new \InvalidArgumentException('Input must either be another StringReader or a string');
        }

        $this->stringParts = preg_split('//u', $this->string, -1, PREG_SPLIT_NO_EMPTY);
        $this->length = count($this->stringParts);
    }

    /**
     * Returns the full string being read.
     *
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * Sets the current position of the cursor.
     *
     * @param integer $cursor
     * @return void
     */
    public function setCursor(int $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns the current position of the cursor.
     *
     * @return integer
     */
    public function getCursor(): int
    {
        return $this->cursor;
    }

    /**
     * Returns the total number of characters in the multibyte string.
     *
     * @return integer
     */
    public function getTotalLength(): int
    {
        return $this->length;
    }

    /**
     * Returns the number of characters left in the string.
     *
     * @return integer
     */
    public function getRemainingLength(): int
    {
        return $this->length - $this->cursor;
    }

    /**
     * Returns the characters before the cursor.
     *
     * @return void
     */
    public function getRead(): string
    {
        return $this->stringParts[$this->cursor];
    }

    /**
     * Returns the characters at and after the cursor.
     *
     * @return string
     */
    public function getRemaining(): string
    {
        return $this->substr($this->cursor, $this->length - 1);
    }

    /**
     * Returns whether or not there's still characters left after the cursor.
     *
     * @param integer $length
     * @return boolean
     */
    public function canRead(int $length = 1): bool
    {
        return $this->cursor + $length <= $this->length;
    }

    /**
     * Returns what the character after the cursor is.
     *
     * @param integer $offset
     * @return string
     */
    public function peek(int $offset = 0): string
    {
        return $this->stringParts[($this->cursor + $offset)] ?? '';
    }

    /**
     * Moves the cursor ahead by 1 and returns the character found.
     *
     * @return string
     */
    public function read(): string
    {
        return $this->stringParts[$this->cursor++] ?? '';
    }

    /**
     * Moves the cursor ahead by 1.
     *
     * @return void
     */
    public function skip(): void
    {
        $this->cursor++;
    }

    /**
     * Validates the character as being allowed in numeric values.
     *
     * @param string $c
     * @return boolean
     */
    public static function isAllowedNumber(string $c): bool
    {
        return isset(self::ALLOWED_NUMBER[$c]);
    }

    /**
     * Validates the encompassing characters for quoted strings.
     *
     * @param string $c
     * @return boolean
     */
    public static function isQuotedStringStart(string $c): bool
    {
        return isset(self::ALLOWED_QUOTES[$c]);
    }

    /**
     * List of characters allowed within an unquoted string.
     *
     * @param string $c
     * @return boolean
     */
    public static function isAllowedInUnquotedString(string $c): bool
    {
        return isset(self::ALLOWED_IN_QUOTED_STRING[$c]);
    }

    /**
     * Moves the cursor past all whitespace characters.
     *
     * @return void
     */
    public function skipWhitespace(): void
    {
        if (\IntlChar::isWhitespace($this->peek())) {

            $this->skip();
            $this->skipWhitespace();
        }
    }

    /**
     * Throws error if the next character is not the specified character.
     *
     * @param string $c
     * @return void
     */
    public function expect(string $c): void
    {
        if (!$this->canRead() || $this->peek() != $c) {

            throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerExpectedSymbol().createWithContext(this, String.valueOf(c));
        }

        $this->skip();
    }

    /**
     * Attempts to find an int.
     *
     * @return integer
     */
    public function readInt(): int
    {
        $start = $this->cursor;

        while ($this->canRead() && self::isAllowedNumber($this->peek())) {

            $this->skip();
        }

        $number = $this->substr($start, $this->cursor);

        if (mb_strlen($number) === 0) {

            throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerExpectedInt().createWithContext(this);
        }

        if (!is_numeric($number)) {

            $this->cursor = $start;
            throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerInvalidInt().createWithContext(this, number);
        }

        return (int)$number;
    }

    /**
     * Attempts to find a long (really an int).
     *
     * @return void
     */
    public function readLong(): int
    {
        return $this->readInt();
    }

    /**
     * Attempts to find a float.
     *
     * @return float
     */
    public function readFloat(): float
    {
        $start = $this->cursor;

        while ($this->canRead() && self::isAllowedNumber($this->peek())) {

            $this->skip();
        }

        $number = $this->substr($start, $this->cursor);

        if (mb_strlen($number) === 0) {

            throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerExpectedFloat().createWithContext(this);
        }

        if (!is_numeric($number)) {

            $this->cursor = $start;
            throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerInvalidFloat().createWithContext(this, number);
        }

        return (float)$number;
    }

    /**
     * Returns a double (actually a float).
     *
     * @return void
     */
    public function readDouble(): float
    {
        return $this->readFloat();
    }

    /**
     * Attempts to find a string that isn't surrounded by quotation marks.
     * 
     * There is a small list of valid characters for unquoted strings as self::isAllowedInUnquotedString.
     * 
     * Returns the completed string.
     *
     * @return string
     */
    public function readUnquotedString(int $start = null): string
    {
        $start = $start ?? $this->cursor;

        if (self::isAllowedInUnquotedString($this->peek())) {

            $this->skip();
            return $this->readUnquotedString($start);
        }
        
        return $this->substr($start, $this->cursor);
    }

    private function substr(int $start, int $until): string
    {
        $buffer = '';

        for ($i = $start; $i < $until; $i++) {

            $buffer .= $this->stringParts[$i];
        }

        return $buffer;
    }

    /**
     * Attempts to find a string that is surrounded by quotation marks.
     * 
     * Returns that string without the quotes.
     *
     * @return string
     */
    public function readQuotedString(): string
    {
        if (!$this->canRead()) {

            return '';
        }

        $next = $this->peek();

        if (!self::isQuotedStringStart($next)) {

            throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerExpectedStartOfQuote().createWithContext(this);
        }

        $this->skip();

        return $this->readStringUntil($next);
    }

    /**
     * Reads the string until it finds the terminating character.
     * 
     * Returns the completed string without that terminating character.
     *
     * @param string $terminator
     * @return string
     */
    public function readStringUntil(string $terminator): string
    {
        $result = '';
        $escaped = false;
        $c = $this->read();

        while ($c != '') {

            if ($escaped) {

                if ($c === $terminator || $c === self::SYNTAX_ESCAPE) {

                    $result .= $c;
                    $escaped = false;
                } else {

                    $this->setCursor($this->getCursor() - 1);
                    throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerInvalidEscape().createWithContext(this, String.valueOf(c));
                }
            } else if ($c === self::SYNTAX_ESCAPE) {

                $escaped = true;
            } else if ($c === $terminator) {

                return $result;
            } else {

                $result .= $c;
            }

            $c = $this->read();
        }

        throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerExpectedEndOfQuote().createWithContext(this);
    }

    /**
     * Attempts to find a string at the cursor.
     * 
     * If quoted, continues until the next quote.
     * 
     * If not quoted, continues until it encounters an invalid character.
     * 
     * Returns the string without the quotes.
     *
     * @return string
     */
    public function readString(): string
    {
        if (!$this->canRead()) {

            return '';
        }

        $next = $this->peek();

        // If the next character is "

        if (self::isQuotedStringStart($next)) {

            // Skip that " character

            $this->skip();

            // And get the string until the next "

            return $this->readStringUntil($next);
        }

        // Otherwise there's no quotes

        return $this->readUnquotedString();
    }

    /**
     * Attempts to find the string representation of a boolean (true & false) at the cursor.
     * 
     * Returns the corresponding bool.
     *
     * @return boolean
     */
    public function readBoolean(): bool
    {
        $start = $this->cursor;
        $value = $this->readString();

        if (mb_strlen($value) === 0) {

            throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerExpectedBool().createWithContext(this);
        }

        if ($value == 'true') {

            return true;
        } else if ($value == 'false') {

            return false;
        } else {

            $this->cursor = $start;

            throw new \Exception('TODO'); // throw CommandSyntaxException.BUILT_IN_EXCEPTIONS.readerInvalidBool().createWithContext(this, value);
        }
    }
}
