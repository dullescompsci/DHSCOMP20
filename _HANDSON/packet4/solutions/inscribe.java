import java.io.File;
import java.util.Scanner;

public class inscribe
{
    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("inscribe.dat"));

        while(fromFile.hasNextInt())
        {
            int size=fromFile.nextInt();
            char[][] grid = new char[size][size];
            int mid = size/2;
            for(int r=0; r<size;r++)
                for(int c=0; c<size;c++)
                {
                    int max = Math.max(Math.abs(r-mid),Math.abs(c-mid));
                    grid[r][c] = (char)('A'+max);
                }

            for(char[] row: grid)
                System.out.println(new String(row));
            System.out.println();
        }
    }
}
